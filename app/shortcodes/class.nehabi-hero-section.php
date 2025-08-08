<?php  
  
  if( ! class_exists( 'Nehabi_Hotel_Slide_Hero_Rooms_Shortcode' ) ){
     class Nehabi_Hotel_Slide_Hero_Rooms_Shortcode{
         public function __construct(){
            add_shortcode('nehabi_hotel_rooms_hero_slide', array( $this, 'nehabi_add_hero_slide_shortcode' ) );
         }
         public function nehabi_add_hero_slide_shortcode( $atts=array(), $content = null, $tag='' ){
            
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
                return esc_html('[nehabi_hotel_rooms_hero_slide]'); // Display the shortcode as text
            }
            

            ob_start();
            require( Nehabi_Hotel_Booking_PATH . 'views/shortcode/nehabi-rooms-slider-hero-show.php' );
      
            
            return ob_get_clean();
         }
     }
  }

