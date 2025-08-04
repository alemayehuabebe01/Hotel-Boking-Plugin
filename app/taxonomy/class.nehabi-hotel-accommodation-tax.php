<?php
if (!class_exists('Nehabi_Hotel_Taxonomies')) {
    class Nehabi_Hotel_Taxonomies {

        public function __construct() {
            add_action('init', array($this, 'register_taxonomies'));
        }

        public function register_taxonomies() {
            //Location Taxonomy
            register_taxonomy('accommodation_category', 'accommodation', array(
                'labels' => array(
                    'name' => _x('Categories', 'taxonomy general name', 'hotel-booking'),
                    'singular_name' => _x('Category', 'taxonomy singular name', 'hotel-booking'),
                    'search_items' => __('Search Categories', 'hotel-booking'),
                    'all_items' => __('All Categories', 'hotel-booking'),
                    'parent_item' => __('Parent Category', 'hotel-booking'),
                    'parent_item_colon' => __('Parent Category:', 'hotel-booking'),
                    'edit_item' => __('Edit Category', 'hotel-booking'),
                    'update_item' => __('Update Category', 'hotel-booking'),
                    'add_new_item' => __('Add New Category', 'hotel-booking'),
                    'new_item_name' => __('New Category Name', 'hotel-booking'),
                    'menu_name' => __('Categories', 'hotel-booking'),
                ),
                'hierarchical' => true, // acts like categories with parent-child
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'category',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
                'show_in_rest' => true, // supports Gutenberg editor and REST API
                'rest_base' => 'accommodation_categories',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
            ));


            // Accommodation Type Taxonomy
            register_taxonomy('accommodation_tag', 'accommodation', array(
                'labels' => array(
                    'name' => _x('Tags', 'taxonomy general name', 'hotel-booking'),
                    'singular_name' => _x('Tag', 'taxonomy singular name', 'hotel-booking'),
                    'search_items' => __('Search Tags', 'hotel-booking'),
                    'all_items' => __('All Tags', 'hotel-booking'),
                    'parent_item' => __('Parent Tag', 'hotel-booking'),
                    'parent_item_colon' => __('Parent Tag:', 'hotel-booking'),
                    'edit_item' => __('Edit Tag', 'hotel-booking'),
                    'update_item' => __('Update Tag', 'hotel-booking'),
                    'add_new_item' => __('Add New Tag', 'hotel-booking'),
                    'new_item_name' => __('New Tag Name', 'hotel-booking'),
                    'menu_name' => __('Tags', 'hotel-booking'),
                ),
                'hierarchical' => true,              // hierarchical = categories style
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'tag',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
                'show_in_rest' => true,
                'rest_base' => 'accommodation_tags',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
            ));


            // Amenities Taxonomy
            register_taxonomy('accommodation_amenity', 'accommodation', array(
                'labels' => array(
                    'name' => _x('Amenities', 'taxonomy general name', 'hotel-booking'),
                    'singular_name' => _x('Amenity', 'taxonomy singular name', 'hotel-booking'),
                    'search_items' => __('Search Amenities', 'hotel-booking'),
                    'all_items' => __('All Amenities', 'hotel-booking'),
                    'parent_item' => __('Parent Amenity', 'hotel-booking'),
                    'parent_item_colon' => __('Parent Amenity:', 'hotel-booking'),
                    'edit_item' => __('Edit Amenity', 'hotel-booking'),
                    'update_item' => __('Update Amenity', 'hotel-booking'),
                    'add_new_item' => __('Add New Amenity', 'hotel-booking'),
                    'new_item_name' => __('New Amenity Name', 'hotel-booking'),
                    'menu_name' => __('Amenities', 'hotel-booking'),
                ),
                'hierarchical' => true,                // Like categories (checkbox tree)
                'show_ui' => true,                     // Show in admin UI
                'show_admin_column' => true,           // Show in admin post list columns
                'show_in_nav_menus' => true,           // Available for nav menus
                'show_tagcloud' => true,               // Enable tag cloud widget
                'query_var' => true,                   // Allow query via ?accommodation_amenity=slug
                'rewrite' => array(
                    'slug' => 'amenity',               // Pretty URL slug base
                    'with_front' => true,              // Use permalink front base (like /blog/)
                    'hierarchical' => true,            // Enable URL like /amenity/parent/child/
                ),
                'show_in_rest' => true,                // Enable Gutenberg + REST API support
                'rest_base' => 'accommodation_amenities',  // REST API base slug
                'rest_controller_class' => 'WP_REST_Terms_Controller',
            ));

        }
    }

   
}
