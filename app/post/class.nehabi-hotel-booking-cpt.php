<?php

if ( ! class_exists( 'Nehabi_Hotel_CPT' ) ) {
    class Nehabi_Hotel_CPT {

        public function __construct() {
            add_action( 'init', array( $this, 'register_booking_cpt' ) );
            add_filter( 'manage_nehabi-hotel-booking_posts_columns', array( $this, 'wishu_booking_custom_columns' ) );
            add_action( 'manage_nehabi-hotel-booking_posts_custom_column', array(
                $this,
                'wishu_booking_custom_column_content'
            ), 10, 2 );
            add_filter( 'manage_edit-nehabi-hotel-booking_sortable_columns', array( $this, 'order_the_table' ) );
            add_action( 'admin_menu', array( $this, 'hb_remove_add_new_submenu' ), 999 );
            add_action( 'admin_head', array( $this, 'hb_hide_add_new_button' ) );
            add_action( 'wp_ajax_change_order_status', array( $this, 'hb_ajax_change_order_status' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'hb_enqueue_order_status_script' ) );
            add_filter('post_row_actions', array($this,'remove_cpt_row_actions'), 10, 2);
            add_filter('bulk_actions-edit-nehabi-hotel-booking', function($bulk_actions) {
                if (isset($bulk_actions['edit'])) {
                    unset($bulk_actions['edit']); // Remove the "Edit" bulk action
                }
                return $bulk_actions;
            });
		}


       public function remove_cpt_row_actions($actions, $post) {
            // Replace 'your_cpt_slug' with your CPT's slug
            if ($post->post_type == 'nehabi-hotel-booking') {
                // Remove unwanted actions
                unset($actions['edit']);       // Edit
                unset($actions['view']);       // View
                unset($actions['inline hide-if-no-js']); // Quick Edit
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
                array(
                    'label'               => __( 'Bookings', 'hotel-booking' ),
                    'description'         => __( 'Bookings', 'hotel-booking' ),
                    'labels'              => array(
                        'name'               => __( 'Bookings', 'hotel-booking' ),
                        'singular_name'      => __( 'Booking', 'hotel-booking' ),
                        'add_new'            => __( 'Create New Booking', 'hotel-booking' ),
                        'add_new_item'       => __( 'Add New Booking', 'hotel-booking' ),
                        'view_item'          => __( 'View Booking', 'hotel-booking' ),
                        'all_items'          => __( 'All Bookings', 'hotel-booking' ),
                        'edit_item'          => __( 'Edit Booking', 'hotel-booking' ),
                        'not_found'          => __( 'Not found', 'hotel-booking' ),
                        'not_found_in_trash' => __( 'Not found in Trash', 'hotel-booking' ),
                    ),
                    'public'              => true,
                    'supports'            => array( 'title', 'editor', 'thumbnail' ),
                    'show_ui'             => true,
                    'show_in_menu'        => true,
                    'show_in_admin_bar'   => true,
                    'show_in_nav_menus'   => true,
                    'can_export'          => true,
                    'has_archive'         => true,
                    'publicly_queryable'  => true,
                    'show_in_rest'        => true,
                    'menu_icon'           => 'dashicons-calendar-alt',
                )
            );
        }

       public function wishu_booking_custom_columns( $columns ) {
				unset( $columns['date'] );
				$columns['status']          = 'Payment Status';
				$columns['check_dates']     = 'Check-in / Check-out';
				$columns['customer_info']   = 'Customer Info';
				$columns['price']           = 'Price';
				$columns['accommodation']   = 'Accommodation';
				$columns['date']            = 'Date';
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
						$check_in  = $item->get_meta( 'Check-in' );
						$check_out = $item->get_meta( 'Check-out' );
						break; // Only first item
					}
					echo ( $check_in && $check_out ) ? esc_html( $check_in . ' / ' . $check_out ) : '-';
					break;

				case 'customer_info':
					echo esc_html( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
					echo '<br>' . esc_html( $order->get_billing_email() );
					break;

				case 'price':
					echo wc_price( $order->get_total() );
					break;

				case 'accommodation':
					$accommodation_id = 0;
					foreach ( $order->get_items() as $item ) {
						$accommodation_id = $item->get_meta( 'accommodation_id' );
						break; // Only first item
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

            $order_id   = intval( $_POST['order_id'] );
            $new_status = sanitize_text_field( $_POST['new_status'] );

            $order = wc_get_order( $order_id );
            if ( $order && $new_status ) {
                $order->update_status( $new_status );
                wp_send_json_success();
            }

            wp_send_json_error();
        }

        public function hb_enqueue_order_status_script() {
            wp_enqueue_script(
                'hb-order-status',
                Nehabi_Hotel_Booking_URL . 'asset/js/order-status.js',
                array( 'jquery' ),
                '1.0',
                true
            );

            wp_localize_script(
                'hb-order-status',
                'myOrderStatus',
                array(
                    'nonce' => wp_create_nonce( 'hb_change_order_status_nonce' ),
                    'ajax'  => admin_url( 'admin-ajax.php' )
                )
            );
        }

        
    }
}
