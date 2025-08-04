<?php

if (!class_exists('Nehabi_Hotel_Accommodation_CPT')) {
    class Nehabi_Hotel_Accommodation_CPT {

        public function __construct() {
            add_action('init', array($this, 'register_accommodation_cpt'));   
        }

        public function register_accommodation_cpt() {
            register_post_type(
                'accommodation',
                array(
                    'label' => __('Accommodations', 'hotel-booking'),
                    'description' => __('Hotel accommodations like rooms or suites', 'hotel-booking'),
                    'labels' => array(
                        'name' => __('Accommodations', 'hotel-booking'),
                        'singular_name' => __('Accommodation', 'hotel-booking'),
                        'add_new' => __('Add New Accommodation Type', 'hotel-booking'),
                        'add_new_item' => __('Add New Accommodation Type', 'hotel-booking'),
                        'edit_item' => __('Edit Accommodation', 'hotel-booking'),
                        'new_item' => __('New Accommodation', 'hotel-booking'),
                        'view_item' => __('View Accommodation', 'hotel-booking'),
                        'view_items' => __('View Accommodations', 'hotel-booking'),
                        'search_items' => __('Search Accommodations', 'hotel-booking'),
                        'not_found' => __('No accommodations found', 'hotel-booking'),
                        'not_found_in_trash' => __('No accommodations found in Trash', 'hotel-booking'),
                        'all_items' => __('Accommodations', 'hotel-booking'),
                        'archives' => __('Accommodation Archives', 'hotel-booking'),
                        'insert_into_item' => __('Insert into accommodation', 'hotel-booking'),
                        'uploaded_to_this_item' => __('Uploaded to this accommodation', 'hotel-booking'),
                        'items_list' => __('Accommodations list', 'hotel-booking'),
                        'items_list_navigation' => __('Accommodations list navigation', 'hotel-booking'),
                        'filter_items_list' => __('Filter accommodations list', 'hotel-booking'),
                        'featured_image' => __('Accommodation Image', 'hotel-booking'),
                        'set_featured_image' => __('Set accommodation image', 'hotel-booking'),
                        'remove_featured_image' => __('Remove accommodation image', 'hotel-booking'),
                        'use_featured_image' => __('Use as accommodation image', 'hotel-booking'),
                        'attributes' => __('Accommodation Attributes', 'hotel-booking'),
                        'parent_item_colon' => __('Parent Accommodation:', 'hotel-booking'),
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'menu_icon' => 'dashicons-admin-home',
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                )
            );

            
        }
    }

}
