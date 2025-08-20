<?php

if (!class_exists('Nehabi_Hotel_Admin_Pages')) {
    class Nehabi_Hotel_Admin_Pages {

        public function __construct() {
            // Define your plugin path constant if it's not defined
            if (!defined('Nehabi_Hotel_Booking_PATH')) {
                define('Nehabi_Hotel_Booking_PATH', plugin_dir_path(__FILE__));
            }

            add_action('admin_menu', array($this, 'add_submenus_to_accommodation'));
             
        }

        public function add_submenus_to_accommodation() {
            // SETTINGS submenu
            add_submenu_page(
                'edit.php?post_type=accommodation',
                __('Accommodation Settings', 'hotel-booking'),
                __('Settings', 'hotel-booking'),
                'manage_options',
                'accommodation-settings',
                array($this, 'render_settings_page')
            );

            // SHORTCODES submenu
            add_submenu_page(
                'edit.php?post_type=accommodation',
                __('Accommodation Shortcodes', 'hotel-booking'),
                __('Shortcodes', 'hotel-booking'),
                'manage_options',
                'accommodation-shortcodes',
                array($this, 'render_shortcodes_page')
            );

               //booking cpt submenu added here 
            add_submenu_page(
                'edit.php?post_type=nehabi-hotel-booking',
                __('Payment Information', 'hotel-booking'),
                __('Payments', 'hotel-booking'),
                'manage_options',
                'accommodation-payment',
                array($this, 'render_payment_page')
            );

            add_submenu_page(
                'edit.php?post_type=nehabi-hotel-booking',
                __('Calander', 'hotel-booking'),
                __('Calander', 'hotel-booking'),
                'manage_options',
                'accommodation-calander',
                array($this, 'render_calander_page')
            );

            add_submenu_page(
                'edit.php?post_type=nehabi-hotel-booking',
                __('Accommodation Customers', 'hotel-booking'),
                __('Customer', 'hotel-booking'),
                'manage_options',
                'accommodation-customer',
                array($this, 'render_customer_page')
            );


            add_submenu_page(
                'edit.php?post_type=nehabi-hotel-booking',
                __('Accommodation Report', 'hotel-booking'),
                __('Report', 'hotel-booking'),
                'manage_options',
                'accommodation-report',
                array($this, 'render_report_page')
            );

        }

        public function render_payment_page(){
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            require_once(Nehabi_Hotel_Booking_PATH . 'views/templates/nehabi_hotel_all_payment_info.php');
        }

        public function render_settings_page() {
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            require_once(Nehabi_Hotel_Booking_PATH . 'views/templates/settings-page.php');
        }

        public function render_shortcodes_page() {
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            require_once(Nehabi_Hotel_Booking_PATH . 'views/templates/nehabi-hotel-accommodation-shortcode.php');
        }

        public function render_customer_page() {
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            require_once(Nehabi_Hotel_Booking_PATH . 'views/templates/nehabi-hotel-booking-customer.php');
        }

        public function render_report_page() {
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            require_once(Nehabi_Hotel_Booking_PATH . 'views/templates/nehabi-hotel-booking-report.php');
        }

        public function render_calander_page() {
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            require_once(Nehabi_Hotel_Booking_PATH . 'views/templates/nehabi-hotel-booking-calander.php');
        }

         
    }
}
