<?php  
  
  if( ! class_exists( 'Nehabi_Hotel_Grid_Rooms_Shortcode' ) ){
     class Nehabi_Hotel_Grid_Rooms_Shortcode{
         public function __construct(){
            add_shortcode('nehabi_hotel_rooms_grid', array( $this, 'nehabi_add_grid_shortcode' ) );
         }
         public function nehabi_add_grid_shortcode( $atts=array(), $content = null, $tag='' ){
            
            $atts = array_change_key_case( (array)$atts, CASE_LOWER );

            extract( shortcode_atts(
                array(
                    'id'=> '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',' , $id ) );
            }

            if (isset($_GET['elementor-preview']) || is_admin()) {
                return esc_html('[nehabi_hotel_rooms_grid]'); // Display the shortcode as text
            }
            

            ob_start();
            require( Nehabi_Hotel_Booking_PATH . 'views/shortcode/nehabi-rooms-grid-list-view.php' );
      
            
            return ob_get_clean();
         }
     }
  }

