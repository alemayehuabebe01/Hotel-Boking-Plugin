<?php 

/**
 * create custom metabox field for property add page
 */

 if( ! class_exists('Nehabi_Accommodation_Other_Metaboxes') ){

    class Nehabi_Accommodation_Other_Metaboxes {
        
        public function __construct(){

            add_action( 'add_meta_boxes', array( $this , 'nehabi_accommodation_other_metaboxes' ) );
            add_action( 'save_post', array( $this , 'nehabi_accommodation_other_metaboxes_save' ) );
            // add_action( 'manage_accommodation_posts_columns', array( $this, 'add_columns' ) );
            // add_filter('manage_accommodation_posts_custom_column', array($this, 'output_column_content'),10,2 );
       
          }


        public function nehabi_accommodation_other_metaboxes(){
           add_meta_box(
             'nehabi_accommodation_other_metabox_id',
             'Others',
             array( $this, 'nehabi_accommodation_other_metaboxes_template' ),
             'accommodation'
           );

        }


        public function nehabi_accommodation_other_metaboxes_template($post){
         
            wp_nonce_field('nehabi_accommodation_nonce_action', 'nehabi_accommodation_nonce');

            $count = get_post_meta($post->ID, '_accommodation_size', true);
            $view = get_post_meta($post->ID, '_accommodation_view', true);
           
            $count = ($count !== '') ? intval($count) : 1; // default to 1

            ?>
            <div style="margin-top: 15px;">
                <label for="accommodation_size" style="font-weight: 600; font-size: 14px; display: inline-block; margin-bottom: 8px;">
                    Size ,m2:
                </label>

                <input type="number"
                    id="accommodation_size"
                    name="accommodation_size"
                    value="<?php echo esc_attr($count); ?>"
                    min="1"
                    step="1"
                    style="width: 100px; padding: 4px 8px; font-size: 14px; border: 1px solid #ccd0d4; border-radius: 4px;" />

                <p style="color: #6c757d; font-size: 13px; margin-top: 4px;">
                    Leave blank to hide.
                </p>
            </div>

            <div style="margin-top: 15px;">
                <label for="accommodation_size" style="font-weight: 600; font-size: 14px; display: inline-block; margin-bottom: 8px;">
                    View
                </label>

                <input type="text"
                    id="accommodation_view"
                    name="accommodation_view"
                    value="<?php echo esc_html($view); ?>"
                    style="width: 500px; padding: 4px 8px; font-size: 14px; border: 1px solid #ccd0d4; border-radius: 4px;"
                    >
                    
                <p style="color: #6c757d; font-size: 13px; margin-top: 4px;">
                    City view, seaside, swimming pool etc.
                </p>
            </div>

             
            <?php


        }

        /**
         * this function save the above input data
         */

         public function nehabi_accommodation_other_metaboxes_save($post_id){

             if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            
             

             if (isset($_POST['accommodation_size'])) {
                update_post_meta($post_id, '_accommodation_size', intval($_POST['accommodation_size']));
             }

             if (isset($_POST['accommodation_view'])) {
                update_post_meta($post_id, '_accommodation_view', $_POST['accommodation_view']);
             }

            //  if (isset($_POST['accommodation_bed_type'])) {
            //     update_post_meta($post_id, '_accommodation_bed_type', $_POST['accommodation_bed_type']);
            //  }
 
  
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

        // public function add_columns( $columns ){

        // /**
        //  * to overide the default columns
        //  */
        //     unset($columns['date']);
        //     unset($columns['title']);
            
        //     //unset($columns['subscription_price']);
         
        //     $columns['date'] = __('Date', 'subscription_plan');
            
        //     return $columns;


        // } 

        /**
         * output Table column values
         */

        //  public function output_column_content($column, $post_id){
             
        //     switch( $column ) {
                 
                    
        //         default:
        //             break;
        //     }

        
        //  }
        

  
    }
    
 }