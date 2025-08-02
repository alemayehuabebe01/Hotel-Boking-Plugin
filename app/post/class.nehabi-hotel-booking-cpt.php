<?php

if (!class_exists('Nehabi_Hotel_CPT')) {
    class Nehabi_Hotel_CPT {

        public function __construct() {
            add_action('init', array($this, 'register_booking_cpt'));   
        }

        public function register_booking_cpt() {
            register_post_type(
                'nehabi-hotel-booking',
                array(
                    'label' => __('Bookings', 'hotel-booking'),
                    'description' => __('Bookings', 'hotel-booking'),
                    'labels' => array(
                        'name' => __('Bookings', 'hotel-booking'),
                        'singular_name' => __('Booking', 'hotel-booking'),
                        'add_new' => __('Create New Booking', 'hotel-booking'),
                        'add_new_item' => __('Add New Booking', 'hotel-booking'),
                        'view_item' => __('View Booking', 'hotel-booking'),
                        'view_items' => __('View Bookings', 'hotel-booking'),
                        'featured_image' => __('Booking Image', 'hotel-booking'),
                        'set_featured_image' => __('Set Booking Image', 'hotel-booking'),
                        'remove_featured_image' => __('Remove Booking Image', 'hotel-booking'),
                        'use_featured_image' => __('Use as Booking Image', 'hotel-booking'),
                        'insert_into_item' => __('Insert into Booking', 'hotel-booking'),
                        'uploaded_to_this_item' => __('Uploaded to this Booking', 'hotel-booking'),
                        'items_list' => __('Booking List', 'hotel-booking'),
                        'items_list_navigation' => __('Booking List Navigation', 'hotel-booking'),
                        'filter_items_list' => __('Filter Booking List', 'hotel-booking'),
                        'archives' => __('Booking Archives', 'hotel-booking'),
                        'attributes' => __('Booking Attributes', 'hotel-booking'),
                        'parent_item_colon' => __('Parent Booking:', 'hotel-booking'),
                        'all_items' => __('All Bookings', 'hotel-booking'),
                        'new_item' => __('New Booking', 'hotel-booking'),
                        'edit_item' => __('Edit Booking', 'hotel-booking'),
                        'update_item' => __('Update Booking', 'hotel-booking'),
                        'search_items' => __('Search Booking', 'hotel-booking'),
                        'not_found' => __('Not found', 'hotel-booking'),
                        'not_found_in_trash' => __('Not found in Trash', 'hotel-booking'),
                    ),
                    'public' => true,
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'hierarchical' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => true,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                    'menu_icon' => 'dashicons-calendar-alt',
                )
            );
        }
    }
}
