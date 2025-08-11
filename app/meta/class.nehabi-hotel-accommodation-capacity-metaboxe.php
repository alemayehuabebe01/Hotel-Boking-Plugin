<?php 

/**
 * create custom metabox field for property add page
 */

 if( ! class_exists('Nehabi_Accommodation_Capacity_Metaboxes') ){

    class Nehabi_Accommodation_Capacity_Metaboxes {
        
        public function __construct(){
            add_action( 'add_meta_boxes', array( $this , 'nehabi_accommodation_capacity_metaboxes' ) );
            add_action( 'save_post', array( $this , 'nehabi_accommodation_capacity_metaboxes_save' ) );
            add_action( 'manage_accommodation_posts_columns', array( $this, 'add_columns' ) );
            add_filter('manage_accommodation_posts_custom_column', array($this, 'output_column_content'),10,2 );
     
          }


        public function nehabi_accommodation_capacity_metaboxes(){
           add_meta_box(
             'nehabi_accommodation_capacity_metabox_id',
             'Capacity',
             array( $this, 'nehabi_accommodation_capacity_metaboxes_template' ),
             'accommodation'
           );

        }

         public function nehabi_accommodation_capacity_metaboxes_template($post){
         
            wp_nonce_field('nehabi_accommodation_nonce_action', 'nehabi_accommodation_nonce');

            // Get saved values (or defaults)
            $adults = get_post_meta($post->ID, '_accommodation_adults', true) ?: 1;
            $children = get_post_meta($post->ID, '_accommodation_children', true) ?: 0;
            $capacity = get_post_meta($post->ID, '_accommodation_capacity', true) ?: '';
            $accommodation_price = get_post_meta($post->ID, '_accommodation_price', true) ?: '';
            $base_adults = get_post_meta($post->ID, '_accommodation_base_adults', true) ?: '';
            $base_children = get_post_meta($post->ID, '_accommodation_base_children', true) ?: '';
            $bed_type = get_post_meta($post->ID, '_accommodation_bed_type', true);

            ?>

            <table class="form-table">
                <tbody>
                     <tr>
                        <th><label for="accommodation_capacity">Base Price</label></th>
                        <td>
                            <input type="number" id="accommodation_price" name="accommodation_price" value="<?php echo esc_attr($accommodation_price); ?>" min="0" step="1" class="small-text">
                            <p class="description">Base Price for the accommodation per night. </p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="accommodation_adults">Adults</label></th>
                        <td>
                            <input type="number" id="accommodation_adults" name="accommodation_adults" value="<?php echo esc_attr($adults); ?>" min="0" step="1" class="small-text">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="accommodation_children">Children</label></th>
                        <td>
                            <input type="number" id="accommodation_children" name="accommodation_children" value="<?php echo esc_attr($children); ?>" min="0" step="1" class="small-text">
                            <p class="description">State the age or disable children in <a href="<?php echo admin_url('options-general.php'); ?>">settings</a>.</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="accommodation_capacity">Capacity</label></th>
                        <td>
                            <input type="number" id="accommodation_capacity" name="accommodation_capacity" value="<?php echo esc_attr($capacity); ?>" min="0" step="1" class="small-text">
                            <p class="description">Leave empty to calculate automatically. Set a manual limit to restrict total guests. E.g., adults:5, children:4, capacity:5 means 5 total guests max.</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="accommodation_base_adults">Base Adults Occupancy</label></th>
                        <td>
                            <input type="number" id="accommodation_base_adults" name="accommodation_base_adults" value="<?php echo esc_attr($base_adults); ?>" min="0" step="1" class="small-text">
                            <p class="description">Optional starting value for seasonal pricing calculations.</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="accommodation_base_children">Base Children Occupancy</label></th>
                        <td>
                            <input type="number" id="accommodation_base_children" name="accommodation_base_children" value="<?php echo esc_attr($base_children); ?>" min="0" step="1" class="small-text">
                            <p class="description">Optional starting value for seasonal pricing calculations.</p>
                        </td>
                    </tr>
                    <tr>
                         <th scope="row">
                            <label for="accommodation_bed_type" style="font-weight: 600; font-size: 14px;">
                                Bed Type:
                            </label>
                        </th>
                        <td>
                            <input type="text"
                                id="accommodation_bed_type"
                                name="accommodation_bed_type"
                                value="<?php echo esc_attr($bed_type); ?>"
                                style="width: 500px; padding: 4px 8px; font-size: 14px; border: 1px solid #ccd0d4; border-radius: 4px;" />

                            <p style="color: #6c757d; font-size: 13px; margin-top: 4px;">
                                Set bed types list in.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php


        }

        /**
         * this function save the above input data
         */

         public function nehabi_accommodation_capacity_metaboxes_save($post_id){

             if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            
             

             if (isset($_POST['accommodation_adults'])) {
                update_post_meta($post_id, '_accommodation_adults', intval($_POST['accommodation_adults']));
             }
             if (isset($_POST['accommodation_children'])) {
                update_post_meta($post_id, '_accommodation_children', intval($_POST['accommodation_children']));
             }

             if (isset($_POST['accommodation_capacity'])) {
                update_post_meta($post_id, '_accommodation_capacity', intval($_POST['accommodation_capacity']));
             }

             if (isset($_POST['accommodation_base_adults'])) {
                update_post_meta($post_id, '_accommodation_base_adults', intval($_POST['accommodation_base_adults']));
             }

             if (isset($_POST['accommodation_base_children'])) {
                update_post_meta($post_id, '_accommodation_base_children', intval($_POST['accommodation_base_children']));
             }
             if (isset($_POST['accommodation_bed_type'])) {
                update_post_meta($post_id, '_accommodation_bed_type', $_POST['accommodation_bed_type']);
             }

             if (isset($_POST['accommodation_price'])) {
                update_post_meta($post_id, '_accommodation_price', $_POST['accommodation_price']);
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
         
                
            $columns['title'] = __('Title', 'accommodation');
            $columns['taxonomy-accommodation_category'] = __('Accommodation Categories', 'accommodation');
            $columns['taxonomy-accommodation_tag'] = __('Accommodation Tags', 'accommodation');
            $columns['taxonomy-accommodation_amenity'] = __('Amenities', 'accommodation');
            $columns['accommodation_bed_type'] = __('Bed Type', 'accommodation');
            $columns['accommodation_children'] = __('Capacity', 'accommodation');
            
            
            $columns['date'] = __('Date', 'accommodation');
            
            return $columns;


        } 

        /**
         * output Table column values
         */

         public function output_column_content($column, $post_id){
             
            switch( $column ) {
               case 'accommodation_children':
                    $accommodation_children = get_post_meta($post_id, '_accommodation_children', true);
                    $accommodation_adults   = get_post_meta($post_id, '_accommodation_adults', true);
                    $accommodation_size     = get_post_meta($post_id, '_accommodation_size', true);

                    echo '<strong>Adults:</strong> ' . esc_html($accommodation_adults) . '<br>';
                    echo '<strong>Children:</strong> ' . esc_html($accommodation_children) . '<br>';
                    echo '<strong>Size:</strong> ' . esc_html($accommodation_size) . 'm²<br>';
                   break; 
               case 'accommodation_bed_type':
                    $bed_type = get_post_meta($post_id, '_accommodation_bed_type', true);
                    echo esc_html($bed_type);
                   break; 
                        
                        
                    
                default:
                    break;
            }

        
         }
        

  
    }
    
 }