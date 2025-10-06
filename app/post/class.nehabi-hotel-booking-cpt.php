<?php

if ( ! class_exists( 'Nehabi_Hotel_CPT' ) ) {
    class Nehabi_Hotel_CPT {

        public function __construct() {
            add_action( 'init', [ $this, 'register_booking_cpt' ], 20 );
            add_filter( 'manage_nehabi-hotel-booking_posts_columns', [ $this, 'wishu_booking_custom_columns' ] );
            add_action( 'manage_nehabi-hotel-booking_posts_custom_column', [ $this, 'wishu_booking_custom_column_content' ], 10, 2 );
            add_filter( 'manage_edit-nehabi-hotel-booking_sortable_columns', [ $this, 'order_the_table' ] );
            add_action( 'admin_menu', [ $this, 'hb_remove_add_new_submenu' ], 999 );
            add_action( 'admin_head', [ $this, 'hb_hide_add_new_button' ] );
            add_action( 'wp_ajax_change_order_status', [ $this, 'hb_ajax_change_order_status' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'hb_enqueue_order_status_script' ] );

            // Remove unwanted row actions
           add_filter( 'post_row_actions', [ $this, 'remove_cpt_row_actions' ], 10, 2 );


            add_filter( 'bulk_actions-edit-nehabi-hotel-booking', function ( $bulk_actions ) {
                unset( $bulk_actions['edit'] );
                return $bulk_actions;
            } );
        }

        public function remove_cpt_row_actions( $actions, $post ) {
            if ( $post->post_type === 'nehabi-hotel-booking' ) {
                unset( $actions['edit'], $actions['view'], $actions['inline hide-if-no-js'] );
            }
            return $actions;
        }

        public function hb_remove_add_new_submenu() {
            remove_submenu_page( 'edit.php?post_type=nehabi-hotel-booking', 'post-new.php?post_type=nehabi-hotel-booking' );
        }

        public function hb_hide_add_new_button() {
            $screen = get_current_screen();
            if ( $screen && $screen->post_type === 'nehabi-hotel-booking' && $screen->base === 'edit' ) {
                echo '<style>.page-title-action{display:none!important;}</style>';
            }
        }

        public function order_the_table( $columns ) {
            $columns['check_dates'] = 'checkin';
            $columns['price']       = 'price';
            return $columns;
        }

        public function register_booking_cpt() {
            register_post_type(
                'nehabi-hotel-booking',
                [
                    'label'               => __( 'Bookings', 'hotel-booking' ),
                    'description'         => __( 'Bookings', 'hotel-booking' ),
                    'labels'              => [
                        'name'               => __( 'Bookings', 'hotel-booking' ),
                        'singular_name'      => __( 'Booking', 'hotel-booking' ),
                        'all_items'          => __( 'All Bookings', 'hotel-booking' ),
                        'edit_item'          => __( 'Edit Booking', 'hotel-booking' ),
                        'not_found'          => __( 'Not found', 'hotel-booking' ),
                        'not_found_in_trash' => __( 'Not found in Trash', 'hotel-booking' ),
                    ],
                    'public'              => true,
                    'supports'            => [ 'title', 'editor' ],
                    'show_ui'             => true,
                    'show_in_menu'        => true,
                    'show_in_admin_bar'   => true,
                    'show_in_nav_menus'   => true,
                    'can_export'          => true,
                    'has_archive'         => true,
                    'publicly_queryable'  => true,
                    'show_in_rest'        => true,
                    'menu_icon'           => 'dashicons-calendar-alt',
                    'capability_type'     => 'post',
                    'map_meta_cap'        => true,
                ]
            );
        }

        public function wishu_booking_custom_columns( $columns ) {
            unset( $columns['date'] );
            $columns['status']        = __( 'Payment Status', 'hotel-booking' );
            $columns['check_dates']   = __( 'Check-in / Check-out', 'hotel-booking' );
            $columns['customer_info'] = __( 'Customer Info', 'hotel-booking' );
            $columns['price']         = __( 'Price', 'hotel-booking' );
            $columns['accommodation'] = __( 'Accommodation', 'hotel-booking' );
            $columns['date']          = __( 'Date', 'hotel-booking' );
            return $columns;
        }

        public function wishu_booking_custom_column_content( $column, $post_id ) {
            $order_id = get_post_meta( $post_id, 'order_id', true );
            if ( ! $order_id ) return;

            $order = wc_get_order( $order_id );
            if ( ! $order ) return;

            switch ( $column ) {
                case 'status':
                    $current_status = $order->get_status();
                    $statuses       = wc_get_order_statuses();
                    ?>
                    <select class="hb-order-status-select"
                            data-order-id="<?php echo esc_attr( $order_id ); ?>"
                            data-nonce="<?php echo esc_attr( wp_create_nonce( 'hb_change_order_status_nonce' ) ); ?>">
                        <?php foreach ( $statuses as $status_key => $status_label ) :
                            $key_slug = str_replace( 'wc-', '', $status_key ); ?>
                            <option value="<?php echo esc_attr( $status_key ); ?>" <?php selected( $current_status, $key_slug ); ?>>
                                <?php echo esc_html( $status_label ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                    break;

                case 'check_dates':
                    $check_in = $check_out = '';
                    foreach ( $order->get_items() as $item ) {
                        // Case-insensitive fetch
                        $check_in  = $item->get_meta( 'Check-in' ) ?: $item->get_meta( 'check-in' );
                        $check_out = $item->get_meta( 'Check-out' ) ?: $item->get_meta( 'check-out' );
                        break;
                    }
                    echo ( $check_in && $check_out ) ? esc_html( "$check_in / $check_out" ) : '-';
                    break;

                case 'customer_info':
                    echo esc_html( $order->get_formatted_billing_full_name() );
                    echo '<br>' . esc_html( $order->get_billing_email() );
                    break;

                case 'price':
                    echo wp_kses_post( wc_price( $order->get_total() ) );
                    break;

                case 'accommodation':
                    $accommodation_id = 0;
                    foreach ( $order->get_items() as $item ) {
                        $accommodation_id = $item->get_meta( 'accommodation_id' );
                        break;
                    }
                    if ( $accommodation_id ) {
                        $acc_post = get_post( $accommodation_id );
                        echo $acc_post ? esc_html( $acc_post->post_title ) : esc_html( $accommodation_id );
                    } else {
                        echo '-';
                    }
                    break;
            }
        }

        public function hb_ajax_change_order_status() {
            check_ajax_referer( 'hb_change_order_status_nonce' );

            $order_id   = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
            $new_status = isset( $_POST['new_status'] ) ? sanitize_text_field( $_POST['new_status'] ) : '';

            if ( ! $order_id || ! $new_status ) {
                wp_send_json_error( [ 'message' => __( 'Invalid request.', 'hotel-booking' ) ] );
            }

            $order = wc_get_order( $order_id );
            if ( $order ) {
                $order->update_status( $new_status );
                wp_send_json_success( [ 'message' => __( 'Order status updated.', 'hotel-booking' ) ] );
            }

            wp_send_json_error( [ 'message' => __( 'Order not found.', 'hotel-booking' ) ] );
        }

        public function hb_enqueue_order_status_script( $hook ) {
            if ( 'edit.php' !== $hook || get_post_type() !== 'nehabi-hotel-booking' ) {
                return;
            }

            $script_path = plugin_dir_path( __FILE__ ) . 'asset/js/order-status.js';
            $script_url  = trailingslashit( Nehabi_Hotel_Booking_URL ) . 'asset/js/order-status.js';

            wp_enqueue_script(
                'hb-order-status',
                $script_url,
                [ 'jquery' ],
                file_exists( $script_path ) ? filemtime( $script_path ) : '1.0',
                true
            );

            wp_localize_script(
                'hb-order-status',
                'myOrderStatus',
                [
                    'nonce' => wp_create_nonce( 'hb_change_order_status_nonce' ),
                    'ajax'  => admin_url( 'admin-ajax.php' )
                ]
            );
        }

    }
}
