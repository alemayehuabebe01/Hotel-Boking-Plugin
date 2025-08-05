<?php 

/**
 * create custom metabox field for property add page
 */

 if( ! class_exists('Nehabi_Accommodation_Metaboxes') ){

    class Nehabi_Accommodation_Metaboxes {
        
        public function __construct(){
            add_action( 'add_meta_boxes', array( $this , 'nehabi_accommodation_metaboxes' ) );
            add_action( 'save_post', array( $this , 'nehabi_accommodation_metaboxes_save' ) );
            add_action( 'manage_accommodation_posts_columns', array( $this, 'add_columns' ) );
            add_filter('manage_accommodation_posts_custom_column', array($this, 'output_column_content'),10,2 );
            add_action('admin_enqueue_scripts', array($this, 'enqueue_accommodation_cpt_admin_styles' ));
            
         
            
          }


        public function nehabi_accommodation_metaboxes(){
           add_meta_box(
             'nehabi_accommodation_metabox_id',
             'Accommodations',
             array( $this, 'nehabi_accommodation_count_metaboxes_template' ),
             'accommodation'
           );

        }


       public function enqueue_accommodation_cpt_admin_styles($hook) {
            // Get the current screen object
            $screen = get_current_screen();
        
            // Check if we're on the post type edit or add screen for your CPT (replace 'your_cpt_slug' with your actual CPT slug)
            if ($screen->post_type == 'accommodation' && in_array($hook, array('post-new.php', 'post.php'))) {
              
                wp_enqueue_style( 'bootstrap-css' );
                wp_enqueue_script( 'bootstrap-js' ); 
           
            }
        }
            
        

        public function nehabi_accommodation_count_metaboxes_template($post){
         
            wp_nonce_field('nehabi_accommodation_nonce_action', 'nehabi_accommodation_nonce');

            $count = get_post_meta($post->ID, '_accommodation_count', true);
            $count = ($count !== '') ? intval($count) : 1; // default to 1
            ?>
            <div style="margin-top: 15px;">
                <label for="accommodation_count" style="font-weight: 600; font-size: 14px; display: inline-block; margin-bottom: 8px;">
                    Number of Accommodations:
                </label><br>

                <input type="number"
                    id="accommodation_count"
                    name="accommodation_count"
                    value="<?php echo esc_attr($count); ?>"
                    min="1"
                    step="1"
                    style="width: 100px; padding: 4px 8px; font-size: 14px; border: 1px solid #ccd0d4; border-radius: 4px;" />

                <p style="color: #6c757d; font-size: 13px; margin-top: 4px;">
                    Count of real accommodations of this type in your hotel.
                </p>
            </div>
            <?php


        }

        /**
         * this function save the above input data
         */

         public function nehabi_accommodation_metaboxes_save($post_id){

             if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            
             

             if (isset($_POST['accommodation_count'])) {
                update_post_meta($post_id, '_accommodation_count', intval($_POST['accommodation_count']));
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
              if (isset($columns['taxonomy-branch_location'])) {
                // remove the branch location column if it exists
                unset($columns['taxonomy-branch_location']);

                }
              
              
              //unset($columns['subscription_price']);
         
            $columns['post_id'] = __('ID', 'subscription_plan');     
            $columns['title'] = __('Plan', 'subscription_plan');
            $columns['subscription_price'] = __('Price', 'subscription_plan');
            $columns['subscription_signup_fee'] = __('Sign Up Fee', 'subscription_plan');
            $columns['subscription_free_trial'] = __('Free Trial', 'subscription_plan');
            $columns['subscription_status'] = __('Status', 'subscription_plan');
            
            $columns['date'] = __('Date', 'subscription_plan');
            
            return $columns;


        } 

        /**
         * output Table column values
         */

         public function output_column_content($column, $post_id){
             
            switch( $column ) {
               
                        
                    
                default:
                    break;
            }

        
         }
        

  
    }
    
 }