<?php

/**
* Plugin Name: Hotel Booking
* Plugin URI: https://nehabi.com/
* Description: Best Plugin To process the reserving accommodation in advance—typically a room in a hotel, resort, or guesthouse. 
* Version: 1.0
* Requires at least: 5.0
* Requires PHP: 7.5
* Author: Alemayehu Abebe
* Author URI: https://ashewatechnology.com
* Text Domain: hotel-booking
* Domain Path: /languages
*/

// If the file is called directly, abort.

if ( ! defined( 'ABSPATH' ) ) {
	exit;  
}


if( !class_exists( 'Nehabi_Hotel_Booking' ) ){

    class Nehabi_Hotel_Booking{

        // Constractor to initialize the plufin
        public function __construct() {

           
            $this->define_constants(); 

            // require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
            // require_once dirname( __FILE__ ) . '/inc/required-plugins.php';

            require_once( Nehabi_Hotel_Booking_PATH . 'app/post/class.nehabi-hotel-booking-cpt.php' );
            $Nehabi_Hotel_Booking = New Nehabi_Hotel_CPT();
 
            require_once( Nehabi_Hotel_Booking_PATH . 'app/post/class.nehabi-hotal-accommodation-cpt.php' );
            $Nehabi_Hotel_Accommodation = New Nehabi_Hotel_Accommodation_CPT();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/post/class.nehabi-hotel-attributes-cpt.php' );
            $Nehabi_Hotel_Attributes_CPT = New Nehabi_Hotel_Attributes_CPT();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/post/class.nehabi-hotel-rooms-cpt.php' );
            $Nehabi_Hotel_Rooms_CPT = New Nehabi_Hotel_Rooms_CPT();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/admin_pages/class.nehabi-submenu-pages.php' );
            $Nehabi_Hotel_Booking_Admin_Pages = New Nehabi_Hotel_Admin_Pages();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-accommodation-metaboxes.php' );
            $Nehabi_Accommodation_Metaboxes = New Nehabi_Accommodation_Metaboxes();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/taxonomy/class.nehabi-hotel-accommodation-tax.php' );
            $Nehabi_Hotel_Taxonomies = New Nehabi_Hotel_Taxonomies();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-accommodation-capacity-metaboxe.php' );
            $Nehabi_Accommodation_Capacity_Metaboxes = New Nehabi_Accommodation_Capacity_Metaboxes();


            add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ), 999);
           

        }

        // Register Scripts and Styles
        public function register_scripts(){
           
            wp_register_script( 'bootstrap-js', Nehabi_Hotel_Booking_URL. 'inc/bootstrap.min.js', array('jquery'), '4.3.1', true );
            wp_register_style( 'bootstrap-css', Nehabi_Hotel_Booking_URL. 'inc/bootstrap.min.css', array(), '4.3.1', 'all' );
            wp_register_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
            wp_register_style('datatables-css', 'https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css');
            wp_register_script('datatables-js', 'https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js', array('jquery'), null, true);
            wp_register_script( 'jszip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', array('jquery'), null, true );
            wp_register_script( 'pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', array('jquery'), null, true );
            wp_register_script( 'vfs_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', array('jquery'), null, true );
        }

       
    

        //Define constants for the plugin path and Url
        public function define_constants(){

            define ( 'Nehabi_Hotel_Booking_PATH', plugin_dir_path( __FILE__ ) );
            define ( 'Nehabi_Hotel_Booking_URL', plugin_dir_url( __FILE__ ) );
            define ( 'Nehabi_Hotel_Booking_VERSION', '1.0.0' );   

        }

        

 
        //Activate hook to register the custom post type.
        public static function activate(){

            update_option('rewrite_rules', '' );

        }

        // Deactivation hook to unregister the custom post type and flush rewrite rules
        public static function deactivate(){
            unregister_post_type( 'nehabi-hotel-booking' );
            flush_rewrite_rules();
        }

        //Uninstall hook to delete all posts of the custom post type
        public static function uninstall(){

            $posts = get_posts(
                array(
                    'post_type' => 'nehabi-hotel-booking',
                    'number_posts' => -1,
                    'post_status' => 'any'
                )               
            );

            foreach( $posts as $post ){
                wp_delete_post( $post->ID, true );
            }

        }

  
}
   // Register Nehabi Hotel Booking Plugin activeation, deactivation and unistall hooks

    if( class_exists( 'Nehabi_Hotel_Booking' ) ){

        register_activation_hook( __FILE__, array( 'Nehabi_Hotel_Booking', 'activate'));
        register_deactivation_hook( __FILE__, array( 'Nehabi_Hotel_Booking', 'deactivate'));
        register_uninstall_hook( __FILE__, array( 'Nehabi_Hotel_Booking', 'uninstall' ) );

        // Initialize the pludin
        $nehabi_hotel_booking= new Nehabi_Hotel_Booking();
    } 
}


