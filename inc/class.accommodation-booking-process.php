<?php
class Nehabi_Hotel_Accommodation_Booking_Proccess {

    private $booking_product_id;

    public function __construct() {
        add_action('init', [$this, 'handle_booking_form']);
        add_action('woocommerce_before_calculate_totals', [$this, 'adjust_price']);
        add_filter('woocommerce_get_item_data', [$this, 'display_cart_item_data'], 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'add_order_item_meta'], 10, 3);
        add_action('woocommerce_order_status_completed', [$this, 'process_completed_order']);

        // Optional: Ensure ALL add to cart redirects go to checkout
        add_filter('woocommerce_add_to_cart_redirect', function($url) {
            return wc_get_checkout_url();
        });

        // Ensure booking product exists
        add_action('init', [$this, 'ensure_booking_product']);
        add_action( 'woocommerce_checkout_order_processed',[$this,'wishu_save_booking_to_cpt'] , 10, 1 );
        add_action( 'woocommerce_order_status_cancelled', array($this,'process_cancelled_order'));
        add_action('init', [$this, 'setup_expired_booking_cron']);
    }

        

    public function wishu_save_booking_to_cpt( $order_id ) {
            $order = wc_get_order( $order_id );
            if ( ! $order ) return;

            foreach ( $order->get_items() as $item ) {
                $accommodation_id = $item->get_meta('accommodation_id');
                $check_in         = $item->get_meta('Check-in');
                $check_out        = $item->get_meta('Check-out');

                if ( ! $accommodation_id ) continue;

                $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                $customer_email = $order->get_billing_email();
                $current_status = $order ? $order->get_status() : 'pending';
                // Create the CPT booking
                $booking_id = wp_insert_post([
                    'post_type'   => 'nehabi-hotel-booking',
                    'post_title'  => "Booking #{$order_id} - {$customer_name}",
                    'post_status' => 'publish',
                ]);

                if ( $booking_id ) {

                    update_post_meta( $booking_id, 'accommodation_id', $accommodation_id );
                    update_post_meta( $booking_id, 'checkin', $check_in );
                    update_post_meta( $booking_id, 'checkout', $check_out );
                    update_post_meta( $booking_id, 'order_id', $order_id );
                    update_post_meta( $booking_id, 'customer_name', $customer_name );
                    update_post_meta( $booking_id, 'customer_email', $customer_email );


                     // Insert into custom table
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

                    $wpdb->insert(
                        $table_name,
                        [
                            'booking_id'       => $booking_id,
                            'order_id'         => $order_id,
                            'payment_method'   => $order->get_payment_method_title(),
                            'payment_total'    => $order->get_total(),
                            'transaction_id'   => $order->get_transaction_id(),
                            'status'           => $current_status,
                            'customer_name'    => $customer_name,
                            'customer_email'   => $customer_email,
                            'check_in'         => $check_in,
                            'check_out'        => $check_out,
                            'accommodation_id' => $accommodation_id,
                        ]
                    );
                }
            }
        }

    /**
     * Create hidden booking product if it doesn't exist
     */
    public function ensure_booking_product() {
        $stored_id = get_option('nehabi_booking_product_id');

        if ($stored_id && get_post_status($stored_id) === 'publish') {
            $this->booking_product_id = $stored_id;
            return;
        }

        // Create new hidden virtual product
        $product = new WC_Product();
        $product->set_name('Accommodation Booking');
        $product->set_status('publish');
        $product->set_catalog_visibility('hidden');
        $product->set_price(0);
        $product->set_regular_price(0);
        $product->set_virtual(true);
        $product->set_downloadable(true);
        $product_id = $product->save();

        // Store for future use
        update_option('nehabi_booking_product_id', $product_id);
        $this->booking_product_id = $product_id;
    }

    /**
     * Handle booking form submission
     */
    public function handle_booking_form() {
        if (isset($_POST['start_booking'])) {
            $accommodation_id = intval($_POST['accommodation_id']);
            $checkin  = sanitize_text_field($_POST['checkin']);
            $checkout = sanitize_text_field($_POST['checkout']);

            WC()->session->set( 'checkin', sanitize_text_field( $_POST['checkin'] ) );
            WC()->session->set( 'checkout', sanitize_text_field( $_POST['checkout'] ) );
            WC()->session->set( 'accommodation_id', intval( $_POST['accommodation_id'] ) );

            // 1️⃣ Check availability
            $available_rooms = (int) get_post_meta($accommodation_id, '_accommodation_count', true);
            $room_status     = get_post_meta($accommodation_id, '_room_status', true);

            if ($available_rooms <= 0 || strtolower($room_status) === 'booked') {
                wc_add_notice(__('Sorry, this accommodation is not available for booking at the moment.'), 'error');
                return;
            }

            // 2️⃣ Prepare booking data
            $booking_data = [
                'accommodation_id' => $accommodation_id,
                'checkin'          => $checkin,
                'checkout'         => $checkout
            ];

            // 3️⃣ Direct checkout: clear cart and add booking product
            $product_id = $this->booking_product_id ?: get_option('nehabi_booking_product_id');
            if (!$product_id) {
                wc_add_notice(__('Booking product is missing. Please contact support.'), 'error');
                return;
            }

            //WC()->cart->empty_cart();
            WC()->cart->add_to_cart($product_id, 1, 0, [], ['booking' => $booking_data]);

            // 4️⃣ Redirect straight to checkout
            wp_safe_redirect(wc_get_checkout_url());
            exit;
        }
    }

    /**
     * Adjust price dynamically based on nights
     */
    public function adjust_price($cart) {
        if (is_admin() && !defined('DOING_AJAX')) return;

        foreach ($cart->get_cart() as $cart_item) {
            if (!empty($cart_item['booking']['accommodation_id'])) {
                $accommodation_id = $cart_item['booking']['accommodation_id'];
                $checkin  = strtotime($cart_item['booking']['checkin']);
                $checkout = strtotime($cart_item['booking']['checkout']);
                $nights   = max(1, ($checkout - $checkin) / DAY_IN_SECONDS);

                $price_per_night = (float) get_post_meta($accommodation_id, '_accommodation_price', true);
                $cart_item['data']->set_price($price_per_night * $nights);
            }
        }
    }

    /**
     * Show booking details in cart/checkout
     */
    public function display_cart_item_data($item_data, $cart_item) {
        if (!empty($cart_item['booking'])) {
            $item_data[] = ['name' => 'Check-in',  'value' => $cart_item['booking']['checkin']];
            $item_data[] = ['name' => 'Check-out', 'value' => $cart_item['booking']['checkout']];
        }
        return $item_data;
    }

    /**
     * Add booking details to order line items
     */
    public function add_order_item_meta($item, $cart_item_key, $values) {
        if (!empty($values['booking'])) {
            $item->add_meta_data('accommodation_id', $values['booking']['accommodation_id']);
            $item->add_meta_data('Check-in',        $values['booking']['checkin']);
            $item->add_meta_data('Check-out',       $values['booking']['checkout']);
        }
    }

        /**
         * When order is marked completed: update room count & send email
         */
        public function process_completed_order($order_id) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

            $order = wc_get_order($order_id);
            if (!$order) return;

            foreach ($order->get_items() as $item) {
                $accommodation_id = $item->get_meta('accommodation_id');
                $checkin  = $item->get_meta('Check-in');
                $checkout = $item->get_meta('Check-out');

                if ($accommodation_id) {
                    // Reduce available rooms
                    $total_rooms = (int) get_post_meta($accommodation_id, '_accommodation_count', true);
                    if ($total_rooms > 0) {
                        update_post_meta($accommodation_id, '_accommodation_count', max(0, $total_rooms - 1));
                    }

                    // Mark as booked if no rooms left
                    if ($total_rooms - 1 <= 0) {
                        update_post_meta($accommodation_id, '_room_status', 'booked');
                    }

                    // Send confirmation email using template
                    $this->send_booking_email($order->get_billing_email(), $accommodation_id, $checkin, $checkout,$order,$order_id);
                }

                // Update custom table to mark this booking as completed
                $wpdb->update(
                    $table_name,
                    ['status' => 'completed'],
                    ['order_id' => $order_id]
                );
            }
        }

        // Release room when order is cancelled
        public function process_cancelled_order($order_id) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

            $order = wc_get_order($order_id);
            if (!$order) return;

            foreach ($order->get_items() as $item) {
                $accommodation_id = $item->get_meta('accommodation_id');
                $checkin  = $item->get_meta('Check-in');
                $checkout = $item->get_meta('Check-out');

                if ($accommodation_id) {
                    // Restore available rooms
                    $total_rooms = (int) get_post_meta($accommodation_id, '_accommodation_count', true);
                    update_post_meta($accommodation_id, '_accommodation_count', $total_rooms + 1);

                    // Mark as available if rooms are greater than 0
                    if ($total_rooms + 1 > 0) {
                        update_post_meta($accommodation_id, '_room_status', 'available');
                    }

                    // ✅ Update ALL rows for this order in custom table
                    $sql = $wpdb->prepare(
                        "UPDATE $table_name
                        SET status = %s,
                            check_in  = NULL,
                            check_out = NULL
                        WHERE order_id = %d",
                        'cancelled',
                        $order_id
                    );

                    $result = $wpdb->query($sql);

                    // Debugging info (remove in production)
                    error_log("Cancelled order update result: " . $result);
                    error_log("Last SQL: " . $wpdb->last_query);
                    error_log("Last error: " . $wpdb->last_error);

                    // Send cancellation email using template
                    $this->send_cancellation_email(
                        $order->get_billing_email(),
                        $accommodation_id,
                        $checkin,
                        $checkout,
                        $order,
                        $order_id
                    );
                }
            }
        }

        /**
     * Send booking cancellation email using template from settings
     */
    public function send_cancellation_email($to, $accommodation_id, $checkin, $checkout,$order,$order_id) {
        $email_options = get_option('nehabi_hotel_email_options');
        
        // Get template from settings or use default
        $template = isset($email_options['cancellation_template']) ? 
            $email_options['cancellation_template'] : 
            $this->get_default_cancellation_template();
        
        // Get design settings
        $primary_color = isset($email_options['primary_color']) ? $email_options['primary_color'] : '#3498db';
        $secondary_color = isset($email_options['secondary_color']) ? $email_options['secondary_color'] : '#2ecc71';
        $background_color = isset($email_options['background_color']) ? $email_options['background_color'] : '#f8f9fa';
        $text_color = isset($email_options['text_color']) ? $email_options['text_color'] : '#333333';
        
        // Get header and footer
        $header = isset($email_options['email_header']) ? $email_options['email_header'] : '';
        $footer = isset($email_options['email_footer']) ? $email_options['email_footer'] : '';
        
        // Replace colors in header and footer
        $header = str_replace('{primary_color}', $primary_color, $header);
        $footer = str_replace('{primary_color}', $primary_color, $footer);
        
        // Accommodation name from CPT
        $accommodation_name = get_the_title($accommodation_id);
        
        // Replace template variables
        $template = str_replace('{customer_name}', $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(), $template);
        $template = str_replace('{booking_id}', $order_id, $template);
        $template = str_replace('{check_in_date}', $checkin, $template);
        $template = str_replace('{check_out_date}', $checkout, $template);
        $template = str_replace('{room_type}', $accommodation_name, $template);
        
        // Replace colors
        $template = str_replace('{primary_color}', $primary_color, $template);
        $template = str_replace('{secondary_color}', $secondary_color, $template);
        $template = str_replace('{background_color}', $background_color, $template);
        $template = str_replace('{text_color}', $text_color, $template);
        
        // Add header and footer
        $template = str_replace('{email_header}', $header, $template);
        $template = str_replace('{email_footer}', $footer, $template);
        
        // Email subject
        $subject = sprintf(
            __('Your booking has been cancelled: %s', 'text-domain'),
            $accommodation_name
        );

        // Headers (HTML email)
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
        ];

        // Send the email
        wp_mail($to, $subject, $template, $headers);
    }

        


   /**
     * Send booking confirmation email using template from settings
     */
    private function send_booking_email($to_email, $accommodation_id, $checkin, $checkout,$order,$order_id) {
        $email_options = get_option('nehabi_hotel_email_options');
        
        // Get template from settings or use default
        $template = isset($email_options['confirmation_template']) ? 
            $email_options['confirmation_template'] : 
            $this->get_default_confirmation_template();
        
        // Get design settings
        $primary_color = isset($email_options['primary_color']) ? $email_options['primary_color'] : '#3498db';
        $secondary_color = isset($email_options['secondary_color']) ? $email_options['secondary_color'] : '#2ecc71';
        $background_color = isset($email_options['background_color']) ? $email_options['background_color'] : '#f8f9fa';
        $text_color = isset($email_options['text_color']) ? $email_options['text_color'] : '#333333';
        
        // Get header and footer
        $header = isset($email_options['email_header']) ? $email_options['email_header'] : '';
        $footer = isset($email_options['email_footer']) ? $email_options['email_footer'] : '';
        
        // Replace colors in header and footer
        $header = str_replace('{primary_color}', $primary_color, $header);
        $footer = str_replace('{primary_color}', $primary_color, $footer);
        
        // Accommodation name from CPT
        $accommodation_name = get_the_title($accommodation_id);
        
        // Get order details
         
        $order = wc_get_order($order_id);
        $customer_name = $order ? $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() : 'Customer';
        $total_amount = $order ? $order->get_total() : '';
        
        // Replace template variables
        $template = str_replace('{customer_name}', $customer_name, $template);
        $template = str_replace('{booking_id}', $order_id, $template);
        $template = str_replace('{check_in_date}', $checkin, $template);
        $template = str_replace('{check_out_date}', $checkout, $template);
        $template = str_replace('{room_type}', $accommodation_name, $template);
        $template = str_replace('{total_amount}', $total_amount, $template);
        
        // Replace colors
        $template = str_replace('{primary_color}', $primary_color, $template);
        $template = str_replace('{secondary_color}', $secondary_color, $template);
        $template = str_replace('{background_color}', $background_color, $template);
        $template = str_replace('{text_color}', $text_color, $template);
        
        // Add header and footer
        $template = str_replace('{email_header}', $header, $template);
        $template = str_replace('{email_footer}', $footer, $template);
        
        // Email subject
        $subject = 'Your Accommodation Booking Confirmation';

        // Headers (HTML email)
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
        ];

        // Send the email
        wp_mail($to_email, $subject, $template, $headers);
    }

    public function send_expired_email($to, $accommodation_id, $checkin, $checkout, $order, $order_id) {
    $email_options = get_option('nehabi_hotel_email_options');
    
    // Get template from settings or use default
    $template = isset($email_options['expired_template']) ? 
        $email_options['expired_template'] : 
        $this->get_default_expired_template();
    
    // Get design settings
    $primary_color = isset($email_options['primary_color']) ? $email_options['primary_color'] : '#3498db';
    $secondary_color = isset($email_options['secondary_color']) ? $email_options['secondary_color'] : '#2ecc71';
    $background_color = isset($email_options['background_color']) ? $email_options['background_color'] : '#f8f9fa';
    $text_color = isset($email_options['text_color']) ? $email_options['text_color'] : '#333333';
    
    // Get header and footer
    $header = isset($email_options['email_header']) ? $email_options['email_header'] : '';
    $footer = isset($email_options['email_footer']) ? $email_options['email_footer'] : '';
    
    // Replace colors in header and footer
    $header = str_replace('{primary_color}', $primary_color, $header);
    $footer = str_replace('{primary_color}', $primary_color, $footer);
    
    // Accommodation name from CPT
    $accommodation_name = get_the_title($accommodation_id);
    
    // Replace template variables
    $template = str_replace('{customer_name}', $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(), $template);
    $template = str_replace('{booking_id}', $order_id, $template);
    $template = str_replace('{check_in_date}', $checkin, $template);
    $template = str_replace('{check_out_date}', $checkout, $template);
    $template = str_replace('{room_type}', $accommodation_name, $template);
    
    // Replace colors
    $template = str_replace('{primary_color}', $primary_color, $template);
    $template = str_replace('{secondary_color}', $secondary_color, $template);
    $template = str_replace('{background_color}', $background_color, $template);
    $template = str_replace('{text_color}', $text_color, $template);
    
    // Add header and footer
    $template = str_replace('{email_header}', $header, $template);
    $template = str_replace('{email_footer}', $footer, $template);
    
    // Email subject
    $subject = sprintf(
        __('Your booking has expired: %s', 'text-domain'),
        $accommodation_name
    );

    // Headers (HTML email)
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    ];

    // Send the email
    wp_mail($to, $subject, $template, $headers);
}

/**
 * Check for expired bookings and send notifications
 * This should be hooked to a cron job or run periodically
 */
public function check_expired_bookings() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';
    
    // Get current date
    $current_date = current_time('Y-m-d');
    
    // Find bookings where checkin date has passed and status is not completed/cancelled/expired
    $expired_bookings = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name 
             WHERE check_in < %s 
             AND status NOT IN ('completed', 'cancelled', 'expired')",
            $current_date
        )
    );
    
    foreach ($expired_bookings as $booking) {
        // Update status to expired
        $wpdb->update(
            $table_name,
            ['status' => 'expired'],
            ['id' => $booking->id]
        );
        
        // Get order details
        $order = wc_get_order($booking->order_id);
        
        if ($order) {
            // Send expired email notification
            $this->send_expired_email(
                $booking->customer_email,
                $booking->accommodation_id,
                $booking->check_in,
                $booking->check_out,
                $order,
                $booking->order_id
            );
            
            // Also update the associated CPT booking status
            $booking_post_id = $booking->booking_id;
            if ($booking_post_id && get_post_status($booking_post_id)) {
                wp_update_post([
                    'ID' => $booking_post_id,
                    'post_status' => 'expired'
                ]);
                
                update_post_meta($booking_post_id, 'booking_status', 'expired');
            }
            
            // Restore available rooms
            $accommodation_id = $booking->accommodation_id;
            $total_rooms = (int) get_post_meta($accommodation_id, '_accommodation_count', true);
            update_post_meta($accommodation_id, '_accommodation_count', $total_rooms + 1);
            
            // Mark as available if rooms are greater than 0
            if ($total_rooms + 1 > 0) {
                update_post_meta($accommodation_id, '_room_status', 'available');
            }
        }
    }
}

/**
 * Default expired template
 */
private function get_default_expired_template() {
    return '<div style="background-color: {background_color}; padding: 20px; font-family: Arial, sans-serif; color: {text_color};">
{email_header}
<div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
    <h2 style="color: {primary_color};">Booking Expired</h2>
    <p>Dear {customer_name},</p>
    <p>We regret to inform you that your booking for <strong>{room_type}</strong> has expired.</p>
    <p><strong>Booking ID:</strong> {booking_id}</p>
    <p><strong>Check-in Date:</strong> {check_in_date}</p>
    <p><strong>Check-out Date:</strong> {check_out_date}</p>
    <p>Your booking was not confirmed within the required time frame, and the accommodation has been released for other guests.</p>
    <p>If you would like to book again, please visit our website to check availability.</p>
    <p>We apologize for any inconvenience this may have caused.</p>
</div>
{email_footer}
</div>';
}

/**
 * Setup cron job to check for expired bookings
 */
public function setup_expired_booking_cron() {
    if (!wp_next_scheduled('nehabi_check_expired_bookings')) {
        wp_schedule_event(time(), 'daily', 'nehabi_check_expired_bookings');
    }
    
    add_action('nehabi_check_expired_bookings', [$this, 'check_expired_bookings']);
}

    /**
     * Default cancellation template
     */
    private function get_default_cancellation_template() {
                return '<div style="background-color: {background_color}; padding: 20px; font-family: Arial, sans-serif; color: {text_color};">
            {email_header}
            <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <h2 style="color: {primary_color};">Booking Cancelled</h2>
                <p>Dear {customer_name},</p>
                <p>Your booking (ID: {booking_id}) has been cancelled.</p>
                <p>If this was a mistake or you need further assistance, please contact us.</p>
            </div>
            {email_footer}
        </div>';
            }

    /**
     * Default confirmation template
     */
    private function get_default_confirmation_template() {
        return '<div style="background-color: {background_color}; padding: 20px; font-family: Arial, sans-serif; color: {text_color};">
    {email_header}
    <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h2 style="color: {primary_color};">Booking Confirmed!</h2>
        <p>Dear {customer_name},</p>
        <p>Your booking has been confirmed. Below are your booking details:</p>
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Booking ID</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{booking_id}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Check-in Date</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{check_in_date}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Check-out Date</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{check_out_date}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Room Type</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{room_type}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Total Amount</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{total_amount}</td>
            </tr>
        </table>
        <p>We look forward to hosting you!</p>
    </div>
    {email_footer}
</div>';
    }
}
