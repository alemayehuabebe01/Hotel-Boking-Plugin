<?php

if (!class_exists('Nehabi_Hotel_Rooms_CPT')) {
    class Nehabi_Hotel_Rooms_CPT {

        public function __construct() {
            add_action('init', array($this, 'register_rooms_cpt')); 
            add_action('admin_menu', array($this, 'adjust_menu_position')); 
            add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
                if ( $post_type === 'nh_rooms' ) {
                    return false;
                }
                return $use_block_editor;
            }, 10, 2 );
            add_action('add_meta_boxes', array($this,'remove_unwanted_metaboxes'), 100);
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

       

        public function remove_unwanted_metaboxes() {
            $post_type = 'nh_rooms';

            // Default WordPress boxes
           // remove_meta_box('submitdiv', $post_type, 'side'); // Publish box
           // remove_meta_box('slugdiv', $post_type, 'normal'); // Slug editor
           remove_meta_box('postimagediv', $post_type, 'side'); // Featured image
           //remove_meta_box('postexcerpt', $post_type, 'normal'); // Excerpt
            //remove_meta_box('trackbacksdiv', $post_type, 'normal');
            //remove_meta_box('commentstatusdiv', $post_type, 'normal');
            //remove_meta_box('commentsdiv', $post_type, 'normal');
            //remove_meta_box('revisionsdiv', $post_type, 'normal');
            //remove_meta_box('authordiv', $post_type, 'normal');
            //remove_meta_box('pageparentdiv', $post_type, 'side'); // For hierarchical CPTs
            remove_meta_box('postcustom', $post_type, 'normal');

            // Remove Astra Settings metabox
            remove_meta_box('astra_settings_meta_box', $post_type, 'normal');
        }
    }
}
