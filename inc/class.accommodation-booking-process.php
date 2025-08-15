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

            WC()->cart->empty_cart();
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
        $order = wc_get_order($order_id);
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

                // Send confirmation email
                $this->send_booking_email($order->get_billing_email(), $accommodation_id, $checkin, $checkout);
            }
        }
    }

    /**
     * Send booking confirmation email
     */
    private function send_booking_email($to_email, $accommodation_id, $checkin, $checkout) {
        $subject = 'Your Accommodation Booking Confirmation';
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        $message  = '<h2>Booking Confirmed!</h2>';
        $message .= '<p>Thank you for booking <strong>' . get_the_title($accommodation_id) . '</strong>.</p>';
        $message .= '<p><strong>Check-in:</strong> ' . esc_html($checkin) . '<br>';
        $message .= '<strong>Check-out:</strong> ' . esc_html($checkout) . '</p>';
        $message .= '<p>We look forward to hosting you!</p>';

        wp_mail($to_email, $subject, $message, $headers);
    }
}
