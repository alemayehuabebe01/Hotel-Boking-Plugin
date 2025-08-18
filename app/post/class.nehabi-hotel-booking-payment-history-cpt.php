<?php

if (!class_exists('Nehabi_Hotel_Booking_Payment_CPT')) {
    class Nehabi_Hotel_Booking_Payment_CPT {

        public function __construct() {
            add_action('init', array($this, 'register_payment_history_cpt'));
            add_action('admin_menu', array($this, 'add_payment_history_submenu'));
            add_action( 'admin_menu', array( $this, 'hb_remove_add_new_submenu' ), 999 );
			add_action( 'admin_head', array( $this, 'hb_hide_add_new_button' ) );
        }

        public function register_payment_history_cpt() {
            register_post_type(
                'nh_payment',
                array(
                    'label' => __('Booking Payments', 'hotel-booking'),
                    'description' => __('Payment records for accommodation bookings', 'hotel-booking'),
                    'labels' => array(
                        'name' => __('Booking Payments', 'hotel-booking'),
                        'singular_name' => __('Booking Payment', 'hotel-booking'),
                        'add_new' => __('Add New Payment', 'hotel-booking'),
                        'add_new_item' => __('Add New Payment', 'hotel-booking'),
                        'edit_item' => __('Edit Payment', 'hotel-booking'),
                        'new_item' => __('New Payment', 'hotel-booking'),
                        'view_item' => __('View Payment', 'hotel-booking'),
                        'view_items' => __('View Payments', 'hotel-booking'),
                        'search_items' => __('Search Payments', 'hotel-booking'),
                        'not_found' => __('No Payments found', 'hotel-booking'),
                        'not_found_in_trash' => __('No Payments found in Trash', 'hotel-booking'),
                        'all_items' => __('All Payments', 'hotel-booking'),
                        'menu_name' => __('Booking Payments', 'hotel-booking'),
                    ),
                    'public' => true,
                    'show_ui' => true,
                    'show_in_menu' => false,
                    'show_in_admin_bar' => false,
                    'show_in_nav_menus' => false,
                    'supports' => array('title', 'editor'),
                    'has_archive' => false,
                    'show_in_rest' => true,
                     
                )
            );
        }

        public function hb_remove_add_new_submenu() {
			remove_submenu_page( 'edit.php?post_type=nh_payment', 'post-new.php?post_type=nh_payment' );
		}

		public function hb_hide_add_new_button() {
			$screen = get_current_screen();
			if ( $screen->post_type === 'nh_payment' && $screen->base === 'edit' ) {
				echo '<style>.page-title-action{display:none!important;}</style>';
			}
		}

        public function add_payment_history_submenu() {
            add_submenu_page(
                'edit.php?post_type=nehabi-hotel-booking', // Parent CPT menu
                __('Booking Payments', 'hotel-booking'), // Page title
                __('Payments', 'hotel-booking'),         // Submenu label
                'manage_options',
                'edit.php?post_type=nh_payment'
            );
        }
    }
}
