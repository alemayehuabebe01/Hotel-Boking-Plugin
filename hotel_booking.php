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

            require_once( Nehabi_Hotel_Booking_PATH . 'app/post/class.nehabi-hotel-season-cpt.php' );
            $Nehabi_Hotel_Seasons_CPT = New Nehabi_Hotel_Seasons_CPT();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/admin_pages/class.nehabi-submenu-pages.php' );
            $Nehabi_Hotel_Booking_Admin_Pages = New Nehabi_Hotel_Admin_Pages();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-accommodation-metaboxes.php' );
            $Nehabi_Accommodation_Metaboxes = New Nehabi_Accommodation_Metaboxes();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-accommodation-other-metaboxe.php' );
            $Nehabi_Accommodation_Other_Metaboxes = New Nehabi_Accommodation_Other_Metaboxes();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-attribute-accommodation-type-select-metaboxes.php' );
            $Nehabi_Attribute_Acco_Type_Select_Metaboxes = New Nehabi_Attribute_Acco_Type_Select_Metaboxes();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-accommodation-gallery.php' );
            $Nehabi_Accommodation_Gallery_Metaboxes = New Nehabi_Accommodation_Gallery_Metaboxes();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-season-metaboxes.php' );
            $Nehabi_Season_Metaboxes = New Nehabi_Season_Metaboxes();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-accommodation-price-metaboxes.php' );
            $Nehabi_Accommodation_Season_Pricing = New Nehabi_Accommodation_Season_Pricing();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/admin_pages/class.nehabi-hotel-setting.php' );
            $Nehabi_Hotel_Settings = New Nehabi_Hotel_Settings();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/taxonomy/class.nehabi-hotel-accommodation-tax.php' );
            $Nehabi_Hotel_Taxonomies = New Nehabi_Hotel_Taxonomies();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/meta/class.nehabi-hotel-accommodation-capacity-metaboxe.php' );
            $Nehabi_Accommodation_Capacity_Metaboxes = New Nehabi_Accommodation_Capacity_Metaboxes();

            require_once( Nehabi_Hotel_Booking_PATH . 'inc/class.accommodation-booking-process.php' );
            $Nehabi_Hotel_Accommodation_Booking_Proccess = New Nehabi_Hotel_Accommodation_Booking_Proccess();

            //load the template files
            add_filter('theme_page_templates',array($this, 'nehabi_homes_templates_register'),10,3);
            add_filter('template_include',array($this, 'nehabi_homes_templates_load'),99);

            //load shortcodes class
            require_once( Nehabi_Hotel_Booking_PATH . 'app/shortcodes/class.nehabi-grid-rooms.php');
            $Nehabi_Hotel_Grid_Rooms_Shortcode = New Nehabi_Hotel_Grid_Rooms_Shortcode();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/shortcodes/class.nehabi-slide-rooms.php');
            $Nehabi_Hotel_Slide_Rooms_Shortcode = New Nehabi_Hotel_Slide_Rooms_Shortcode();

            require_once( Nehabi_Hotel_Booking_PATH . 'app/shortcodes/class.nehabi-hero-section.php');
            $Nehabi_Hotel_Slide_Hero_Rooms_Shortcode = New Nehabi_Hotel_Slide_Hero_Rooms_Shortcode();

            add_filter( 'single_template', array( $this, 'load_custom_nehabi_single_template' ) );
            add_filter( 'single_template', array( $this, 'load_custom_nehabi_room_single_template' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ), 999);
            add_filter( 'woocommerce_checkout_fields' , array($this,'wishu_add_booking_fields') );
            add_filter( 'woocommerce_checkout_fields', array($this,'wishu_remove_default_checkout_fields'), 20, 1 );
            add_action( 'woocommerce_checkout_update_order_meta', array($this,'wishu_save_custom_checkout_fields_to_order') );
            register_activation_hook( __FILE__, array($this,'wishu_create_payment_table') );
            

          
        }

      public function wishu_create_payment_table() {
            global $wpdb;

            $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                booking_id BIGINT(20) UNSIGNED NOT NULL,
                order_id BIGINT(20) UNSIGNED NOT NULL,
                payment_method VARCHAR(100),
                payment_total DECIMAL(10,2),
                transaction_id VARCHAR(100),
                status VARCHAR(50),
                customer_name VARCHAR(200),
                customer_email VARCHAR(200),
                check_in DATE,
                check_out DATE,
                accommodation_id BIGINT(20) UNSIGNED,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY booking_id (booking_id),
                KEY order_id (order_id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }


        /**
         * Remove default WooCommerce checkout fields
         */
        public  function wishu_remove_default_checkout_fields( $fields ) {

            // Remove billing fields you don’t want
            unset( $fields['billing']['billing_company'] );
            unset( $fields['billing']['billing_address_1'] );
            unset( $fields['billing']['billing_postcode'] );
            unset( $fields['billing']['billing_state'] );
            // OPTIONAL: also remove shipping fields if you're not shipping anything
            unset( $fields['shipping'] );

            return $fields;
        }


        public function wishu_add_booking_fields( $fields ) {
                $accommodation_id = WC()->session->get( 'accommodation_id' );
                $check_in         = WC()->session->get( 'checkin' );
                $check_out        = WC()->session->get( 'checkout' );

                $fields['billing']['accommodation_id'] = array(
                    'type'     => 'number',
                    'label'    => 'Accommodation ID',
                    'required' => true,
                    'default'  => $accommodation_id
                );

                $fields['billing']['checkin'] = array(
                    'type'     => 'text',
                    'label'    => 'Check-in Date',
                    'required' => true,
                    'default'  => $check_in
                );

                $fields['billing']['checkout'] = array(
                    'type'    => 'text',
                    'label'    => 'Check-out Date',
                    'required' => true,
                    'default'  => $check_out
                );

            
                return $fields;
            }


            /**
             * Save custom checkout fields to order meta
             */
            public function wishu_save_custom_checkout_fields_to_order( $order_id ) {
                if ( isset( $_POST['accommodation_id'] ) ) {
                    update_post_meta( $order_id, 'accommodation_id', sanitize_text_field( $_POST['accommodation_id'] ) );
                }
                if ( isset( $_POST['checkin'] ) ) {
                    update_post_meta( $order_id, 'checkin', sanitize_text_field( $_POST['checkin'] ) );
                }
                if ( isset( $_POST['checkout'] ) ) {
                    update_post_meta( $order_id, 'checkout', sanitize_text_field( $_POST['checkout'] ) );
                }
            }


        // Register Scripts and Styles
        public function register_scripts(){
         
            wp_register_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
            wp_register_style('datatables-css', 'https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css');
            wp_register_script('datatables-js', 'https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js', array('jquery'), null, true);
            wp_register_script( 'jszip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', array('jquery'), null, true );
            wp_register_script( 'pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', array('jquery'), null, true );
            wp_register_script( 'vfs_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', array('jquery'), null, true );

            wp_register_script( 'toastr', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js', [], '2.1.4', true );
            wp_register_style( 'toastr-css', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css', [], '2.1.4' );  

           wp_register_script(
                'email-color-picker',
                Nehabi_Hotel_Booking_PATH . 'asset/js/nehabi-admin.js',
                array('jquery', 'wp-color-picker'),  
                '2.1.4',
                true
            );

            wp_register_style('datatables', 'https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
    wp_register_script('datatables', 'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', array('jquery'), null, true);

            wp_enqueue_style('toastr-css');
            wp_enqueue_script('toastr');
            wp_enqueue_script('email-color-picker');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
        }


       
    

        //Define constants for the plugin path and Url
        public function define_constants(){

            define ( 'Nehabi_Hotel_Booking_PATH', plugin_dir_path( __FILE__ ) );
            define ( 'Nehabi_Hotel_Booking_URL', plugin_dir_url( __FILE__ ) );
            define ( 'Nehabi_Hotel_Booking_VERSION', '1.0.0' );   

        }

        public function nehabi_hotel_templates_array(){
            $temps = [];

            $temps['nehabi_hotel_all_accommodation.php'] = 'All Accommodations';
       
            return $temps;
        }

        public function nehabi_homes_templates_register($page_template,$theme,$post){
            
          $templates = $this->nehabi_hotel_templates_array();
          foreach($templates as $tk=> $tv){

            $page_template[$tk] = $tv;

          }

          return $page_template;

        }

        public function nehabi_homes_templates_load($template) {
            global $post, $wp_query, $wpdb;

            if ( isset($post) && $post instanceof WP_Post ) {
                $nehabi_page_temp_slug = get_page_template_slug($post->ID);

                if ( !empty($nehabi_page_temp_slug) ) {
                    $custom_template_path = Nehabi_Hotel_Booking_PATH . 'views/templates/' . $nehabi_page_temp_slug;

                    if ( file_exists($custom_template_path) ) {
                        $template = $custom_template_path;
                    } else {
                        error_log("Template not found: " . $custom_template_path);
                    }
                }
            }

            return $template;
        }


        public function load_custom_nehabi_single_template( $tpl ){  
                 
                if( is_singular('accommodation') ){

                $tpl = Nehabi_Hotel_Booking_PATH. 'views/templates/single-accommodation.php';   
                }   
                return $tpl;
        }
        
         public function load_custom_nehabi_room_single_template( $tpl ){  
                 
                if( is_singular('nh_rooms') ){

                $tpl = Nehabi_Hotel_Booking_PATH. 'views/templates/single-nh_rooms.php';   
                }   
                return $tpl;
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


