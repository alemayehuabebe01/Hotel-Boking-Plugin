<?php

if ( ! class_exists( 'Nehabi_Hotel_Seasons_CPT' ) ) {
    class Nehabi_Hotel_Seasons_CPT {

        public function __construct() {
            add_action( 'init', array( $this, 'register_seasons_cpt' ) );
            add_action( 'admin_menu', array( $this, 'adjust_menu_position' ) );
            add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
                if ( $post_type === 'nh_seasons' ) {
                    return false;
                }
                return $use_block_editor;
            }, 10, 2 );
            add_action( 'add_meta_boxes', array( $this, 'remove_unwanted_metaboxes' ), 100 );
        }

        public function register_seasons_cpt() {
            register_post_type(
                'nh_seasons',
                array(
                    'label' => __( 'Seasons', 'hotel-booking' ),
                    'description' => __( 'Seasonal date ranges for special pricing', 'hotel-booking' ),
                    'labels' => array(
                        'name'               => __( 'Seasons', 'hotel-booking' ),
                        'singular_name'      => __( 'Season', 'hotel-booking' ),
                        'add_new'            => __( 'Add New Season', 'hotel-booking' ),
                        'add_new_item'       => __( 'Add New Season', 'hotel-booking' ),
                        'edit_item'          => __( 'Edit Season', 'hotel-booking' ),
                        'new_item'           => __( 'New Season', 'hotel-booking' ),
                        'view_item'          => __( 'View Season', 'hotel-booking' ),
                        'view_items'         => __( 'View Seasons', 'hotel-booking' ),
                        'search_items'       => __( 'Search Seasons', 'hotel-booking' ),
                        'not_found'          => __( 'No Seasons found', 'hotel-booking' ),
                        'not_found_in_trash' => __( 'No Seasons found in Trash', 'hotel-booking' ),
                        'all_items'          => __( 'All Seasons', 'hotel-booking' ),
                        'menu_name'          => __( 'Seasons', 'hotel-booking' ),
                    ),
                    'public'             => true,
                    'show_ui'            => true,
                    'show_in_menu'       => false, // we'll attach it under Rooms or Accommodation
                    'show_in_admin_bar'  => false,
                    'show_in_nav_menus'  => false,
                    'supports'           => array( 'title' ), // we’ll handle start date, end date, price via meta boxes
                    'has_archive'        => false,
                    'show_in_rest'       => false, // keep classic editor for date inputs
                    'rewrite'            => array( 'slug' => 'season' ),
                )
            );
        }

        // Add Seasons as submenu under Rooms or Accommodation
        public function adjust_menu_position() {
            add_submenu_page(
                'edit.php?post_type=accommodation', // parent CPT menu
                __( 'Seasons', 'hotel-booking' ),  // page title
                __( 'Seasons', 'hotel-booking' ),  // menu title
                'manage_options',
                'edit.php?post_type=nh_seasons'     // CPT slug
            );
        }

        public function remove_unwanted_metaboxes() {
            $post_type = 'nh_seasons';
            remove_meta_box( 'postimagediv', $post_type, 'side' );
            remove_meta_box( 'postcustom', $post_type, 'normal' );
            remove_meta_box( 'astra_settings_meta_box', $post_type, 'normal' );
        }
    }
}

