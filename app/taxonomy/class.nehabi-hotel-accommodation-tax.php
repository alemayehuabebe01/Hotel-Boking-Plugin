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
                    'name' => 'Categories',
                    'singular_name' => 'Category',
                    'add_new_item' => 'Add New Category',
                    'edit_item' => 'Edit Category',
                    'view_item' => 'View Category',
                    'search_items' => 'Search Categorys',
                ),
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'rewrite' => array('slug' => 'category'),
            ));

            // Accommodation Type Taxonomy
            register_taxonomy('accommodation_tag', 'accommodation', array(
                'labels' => array(
                    'name' => 'Tags',
                    'singular_name' => 'Tag',
                    'add_new_item' => 'Add New Tag',
                    'edit_item' => 'Edit Tags',
                    'view_item' => 'View Tags',
                    'search_items' => 'Search Tags',
                ),
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'rewrite' => array('slug' => 'tag'),
            ));

            // Amenities Taxonomy
            register_taxonomy('accommodation_amenity', 'accommodation', array(
                'labels' => array(
                    'name' => 'Amenities',
                    'singular_name' => 'Amenity',
                    'add_new_item' => 'Add New Amenity',
                    'edit_item' => 'Edit Amenity',
                    'view_item' => 'View Amenity',
                    'search_items' => 'Search Amenities',
                ),
                'hierarchical' => false,
                'show_ui' => true,
                'show_admin_column' => true,
                'rewrite' => array('slug' => 'amenity'),
            ));
        }
    }

   
}
