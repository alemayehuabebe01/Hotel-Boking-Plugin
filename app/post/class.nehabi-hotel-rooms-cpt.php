<?php

if (!class_exists('Nehabi_Hotel_Rooms_CPT')) {
    class Nehabi_Hotel_Rooms_CPT {

        public function __construct() {
            add_action('init', array($this, 'register_rooms_cpt')); 
            add_action('admin_menu', array($this, 'adjust_menu_position')); 
        }

        public function register_rooms_cpt() {
            register_post_type(
                'nh_rooms',
                array(
                    'label' => __('Rooms', 'hotel-booking'),
                    'description' => __('Individual room listings for accommodation', 'hotel-booking'),
                    'labels' => array(
                        'name' => __('Rooms', 'hotel-booking'),
                        'singular_name' => __('Room', 'hotel-booking'),
                        'add_new' => __('Add New Room', 'hotel-booking'),
                        'add_new_item' => __('Add New Room', 'hotel-booking'),
                        'edit_item' => __('Edit Room', 'hotel-booking'),
                        'new_item' => __('New Room', 'hotel-booking'),
                        'view_item' => __('View Room', 'hotel-booking'),
                        'view_items' => __('View Rooms', 'hotel-booking'),
                        'search_items' => __('Search Rooms', 'hotel-booking'),
                        'not_found' => __('No Rooms found', 'hotel-booking'),
                        'not_found_in_trash' => __('No Rooms found in Trash', 'hotel-booking'),
                        'all_items' => __('All Rooms', 'hotel-booking'),
                        'menu_name' => __('Rooms', 'hotel-booking'),
                    ),
                    'public' => true,
                    'show_ui' => true,
                    'show_in_menu' => false, // Hide from top-level menu
                    'show_in_admin_bar' => false,
                    'show_in_nav_menus' => false,
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'has_archive' => true,
                    'show_in_rest' => true,
                    'rewrite' => array('slug' => 'room'),
                )
            );
        }

        // Add Rooms as a submenu under your 'accommodation' CPT
        public function adjust_menu_position() {
            add_submenu_page(
                'edit.php?post_type=accommodation', // Parent CPT menu slug
                __('Rooms', 'hotel-booking'),       // Page title
                __('Rooms', 'hotel-booking'),       // Menu title
                'manage_options',                   // Capability
                'edit.php?post_type=nh_rooms'       // Submenu link (must match CPT slug)
            );
        }
    }
}
