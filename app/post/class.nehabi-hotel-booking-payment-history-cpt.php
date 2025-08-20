<?php

if ( ! class_exists( 'Nehabi_Hotel_Booking_Payment_CPT' ) ) {
    class Nehabi_Hotel_Booking_Payment_CPT {

        public function __construct() {
            add_action( 'init', array( $this, 'register_payment_history_cpt' ) );
            add_action( 'admin_menu', array( $this, 'add_payment_history_submenu' ) );
            add_action( 'admin_menu', array( $this, 'hb_remove_add_new_submenu' ), 999 );
            add_action( 'admin_head', array( $this, 'hb_hide_add_new_button' ) );
            
            // Admin columns
            add_filter( 'manage_nh_payment_posts_columns', array( $this, 'set_payment_columns' ) );
            add_action( 'manage_nh_payment_posts_custom_column', array( $this, 'render_payment_columns' ), 10, 2 );
        }

        /** Register Payment CPT */
        public function register_payment_history_cpt() {
            register_post_type( 'nh_payment', array(
                'label'        => __( 'Booking Payments', 'hotel-booking' ),
                'labels'       => array(
                    'name'                     => __( 'Booking Payments', 'hotel-booking' ),
                    'singular_name'            => __( 'Booking Payment', 'hotel-booking' ),
                    'all_items'                => __( 'All Payments', 'hotel-booking' ),
                    'not_found'                => __( 'No Payments found', 'hotel-booking' ),
                    'not_found_in_trash'       => __( 'No Payments found in Trash', 'hotel-booking' ),
                ),
                'public'       => true,
                'show_ui'      => true,
                'show_in_menu' => false,
                'supports'     => array( 'title', 'editor' ),
                'show_in_rest' => true
            ) );
        }

        /** Hide native “Add New” */
        public function hb_remove_add_new_submenu() {
            remove_submenu_page( 'edit.php?post_type=nh_payment', 'post-new.php?post_type=nh_payment' );
        }

        public function hb_hide_add_new_button() {
            $screen = get_current_screen();
            if ( $screen->post_type === 'nh_payment' && $screen->base === 'edit' ) {
                echo '<style>.page-title-action{ display:none !important; }</style>';
            }
        }

        /** Add submenu under Bookings */
        public function add_payment_history_submenu() {
            add_submenu_page(
                'edit.php?post_type=nehabi-hotel-booking',
                __( 'Booking Payments', 'hotel-booking' ),
                __( 'Payments', 'hotel-booking' ),
                'manage_options',
                'edit.php?post_type=nh_payment'
            );
        }

        /** Define admin columns */
        public function set_payment_columns( $columns ) {
            $columns['booking_title']    = 'Booking';
            $columns['customer_name']    = 'Customer Name';
            $columns['customer_email']   = 'Customer Email';
            $columns['payment_method']   = 'Payment Method';
            $columns['payment_total']    = 'Total';
            $columns['transaction_id']   = 'Transaction ID';
            $columns['check_in']         = 'Check-in';
            $columns['check_out']        = 'Check-out';
            $columns['accommodation']    = 'Accommodation';
            return $columns;
        }

        /** Render admin columns */
        public function render_payment_columns( $column, $post_id ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

            // Get payment row from custom table
            $payment_data = $wpdb->get_row(
                $wpdb->prepare("SELECT * FROM {$table_name} "),
                ARRAY_A
            );

            var_dump( $payment_data );

            if ( ! $payment_data ) {
                echo '—';
                return;
            }

            switch ( $column ) {

                case 'booking_title':
                    $booking_post = get_post( $payment_data['booking_id'] );
                    echo $booking_post ? esc_html( $booking_post->post_title ) : esc_html( $payment_data['booking_id'] );
                    break;

                case 'customer_name':
                    echo !empty($payment_data['customer_name']) ? esc_html( $payment_data['customer_name'] ) : '—';
                    break;

                case 'customer_email':
                    echo !empty($payment_data['customer_email']) ? esc_html( $payment_data['customer_email'] ) : '—';
                    break;

                case 'payment_method':
                    echo !empty($payment_data['payment_method']) ? esc_html( $payment_data['payment_method'] ) : '—';
                    break;

                case 'payment_total':
                    echo isset($payment_data['payment_total']) ? wc_price( $payment_data['payment_total'] ) : '—';
                    break;

                case 'transaction_id':
                    echo !empty($payment_data['transaction_id']) ? esc_html( $payment_data['transaction_id'] ) : '—';
                    break;

                case 'check_in':
                    echo !empty($payment_data['check_in']) ? esc_html( $payment_data['check_in'] ) : '—';
                    break;

                case 'check_out':
                    echo !empty($payment_data['check_out']) ? esc_html( $payment_data['check_out'] ) : '—';
                    break;

                case 'accommodation':
                    $acc_post = get_post( $payment_data['accommodation_id'] );
                    echo $acc_post ? esc_html( $acc_post->post_title ) : esc_html( $payment_data['accommodation_id'] );
                    break;

                default:
                    echo '—';
            }
        }
    }
}
