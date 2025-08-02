<?php

if (!class_exists('Nehabi_Hotel_Admin_Pages')) {
    class Nehabi_Hotel_Admin_Pages {

        public function __construct() {
            add_action('admin_menu', array($this, 'add_submenus_to_accommodation'));
        }

        public function add_submenus_to_accommodation() {
            // SETTINGS submenu
            add_submenu_page(
                'edit.php?post_type=accommodation', // Parent slug (your CPT)
                __('Accommodation Settings', 'hotel-booking'), // Page title
                __('Settings', 'hotel-booking'), // Menu title
                'manage_options', // Capability
                'accommodation-settings', // Menu slug
                array($this, 'render_settings_page') // Callback function
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
        }

        // Settings page HTML
        public function render_settings_page() {
            require_once( Nehabi_Hotel_Booking_PATH . 'views/templates/nehabi-hotel-accommodation-setting.php' );
        }

        // Shortcodes page HTML
        public function render_shortcodes_page() {

            require_once( Nehabi_Hotel_Booking_PATH . 'views/templates/nehabi-hotel-accommodation-shortcode.php' );
        }
    }
}
