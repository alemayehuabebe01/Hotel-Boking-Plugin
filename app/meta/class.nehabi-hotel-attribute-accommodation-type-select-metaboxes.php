<?php 

/**
 * create custom metabox field for property add page
 */

 if( ! class_exists('Nehabi_Attribute_Acco_Type_Select_Metaboxes') ){

    class Nehabi_Attribute_Acco_Type_Select_Metaboxes {
        
        public function __construct(){
            add_action( 'add_meta_boxes', array( $this , 'nehabi_select_accommodation_type_metaboxes' ) );
            add_action( 'save_post', array( $this , 'nehabi_select_accommodation_type_metaboxes_save' ) );
            add_action( 'manage_nh_rooms_posts_columns', array( $this, 'add_columns' ) );
            add_filter('manage_nh_rooms_posts_custom_column', array($this, 'output_column_content'),10,2 );
            //add_action('admin_enqueue_scripts', array($this, 'enqueue_accommodation_cpt_admin_styles' ));
        
          }


        public function nehabi_select_accommodation_type_metaboxes(){
           add_meta_box(
             'nehabi_select_accommodation_type_metabox_id',
             'Accommodations Type',
             array( $this, 'nehabi_select_accommodation_type_metaboxes_template' ),
             'nh_rooms'
           );

        }

       public function nehabi_select_accommodation_type_metaboxes_template($post) {
            // Get the saved value (if editing existing post)
            $selected_type = get_post_meta($post->ID, '_selected_accommodation_type', true);

            // Query accommodation_type CPT
            $types = get_posts([
                'post_type'      => 'accommodation',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);
            ?>

            <select name="accommodation_type_select" id="accommodation_type_select" style="width: 300px; padding: 6px;">
                <option value="">-- Select Type --</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo esc_attr($type->ID); ?>" <?php selected($selected_type, $type->ID); ?>>
                        <?php echo esc_html($type->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?php
        }

        /**
         * this function save the above input data
         */

         public function nehabi_select_accommodation_type_metaboxes_save($post_id){

             if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            
             if (isset($_POST['accommodation_type_select'])) {
                    update_post_meta($post_id, '_selected_accommodation_type', sanitize_text_field($_POST['accommodation_type_select']));
                }
 
  
         }

         /**
          * get the input valeus
          */
        public function nehabi_member_subscription_values(){
             if( isset($value) && ! empty($value) ){
                return $value;
             }else{
                return '';
             }
        }

        /**
         * This Function is for customize the all properties data-table columons
         */

         /**
          * add columns to data tables
          */

        public function add_columns( $columns ){

            /**
             * to overide the default columns
             */
              unset($columns['date']);
              unset($columns['title']);
             
         
                
            $columns['title'] = __('Room Title', 'nh_rooms');
            $columns['accommodation_type_select'] = __('Accommodation Selected', 'nh_rooms');
            
            $columns['date'] = __('Date', 'nh_rooms');
            
            return $columns;


        } 

        /**
         * output Table column values
         */

         public function output_column_content($column, $post_id){
             
            switch( $column ) {
                 case 'accommodation_type_select':
                    $selected_type = get_post_meta($post_id, '_selected_accommodation_type',true);
                    if($selected_type){
                        echo esc_html(get_the_title($selected_type));
                    }else{
                            echo __('No Type Selected', 'nh_rooms');
                        }
                 break;
                
                default:
                    break;
            }

        
         }
        

  
    }
    
 }