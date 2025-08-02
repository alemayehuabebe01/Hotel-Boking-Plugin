<?php

if (!class_exists('Nehabi_Hotel_Attributes_CPT')) {
    class Nehabi_Hotel_Attributes_CPT {

        public function __construct() {
            add_action('init', array($this, 'register_attributes_cpt')); 
            add_action('admin_menu', array($this, 'adjust_menu_position')); 
        }

        public function register_attributes_cpt() {
            register_post_type(
                'nh_attribute',
                array(
                    'label' => __('Attributes', 'hotel-booking'),
                    'description' => __('Custom attributes for accommodation', 'hotel-booking'),
                    'labels' => array(
                        'name' => __('Attributes', 'hotel-booking'),
                        'singular_name' => __('Attribute', 'hotel-booking'),
                        'add_new' => __('Add New Attribute', 'hotel-booking'),
                        'add_new_item' => __('Add New Attribute', 'hotel-booking'),
                        'edit_item' => __('Edit Attribute', 'hotel-booking'),
                        'new_item' => __('New Attribute', 'hotel-booking'),
                        'view_item' => __('View Attribute', 'hotel-booking'),
                        'view_items' => __('View Attributes', 'hotel-booking'),
                        'search_items' => __('Search Attributes', 'hotel-booking'),
                        'not_found' => __('No Attributes found', 'hotel-booking'),
                        'not_found_in_trash' => __('No Attributes found in Trash', 'hotel-booking'),
                        'all_items' => __('All Attributes', 'hotel-booking'),
                        'menu_name' => __('Attributes', 'hotel-booking'),
                    ),
                    'public' => true,
                    'show_ui' => true,
                    'show_in_menu' => false, // Hide from top-level menu
                    'show_in_admin_bar' => false,
                    'show_in_nav_menus' => false,
                    'supports' => array('title', 'editor'),
                    'has_archive' => false,
                    'show_in_rest' => true,
                   // 'menu_icon' => 'dashicons-tag',
                )
            );
        }

        // Add it as submenu under another CPT (adjust slug accordingly)
        public function adjust_menu_position() {
            add_submenu_page(
                'edit.php?post_type=accommodation', // Parent CPT menu
                __('Attributes', 'hotel-booking'),                // Page title
                __('Attributes', 'hotel-booking'),                // Menu title
                'manage_options',                                 // Capability
                'edit.php?post_type=nh_attribute'       // Submenu link
            );
        }
    }

}
