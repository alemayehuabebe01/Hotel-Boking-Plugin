<?php 

/**
 * create custom metabox field for property add page
 */

 if( ! class_exists('Nehabi_Accommodation_Gallery_Metaboxes') ){

    class Nehabi_Accommodation_Gallery_Metaboxes {
        
        public function __construct(){
            add_action( 'add_meta_boxes', array( $this , 'nehabi_accommodation_metaboxes' ) );
            add_action( 'save_post', array( $this , 'nehabi_accommodation_metaboxes_save' ) );
            add_action( 'manage_accommodation_posts_columns', array( $this, 'add_columns' ) );
            add_filter('manage_accommodation_posts_custom_column', array($this, 'output_column_content'),10,2 );
             
          }


        public function nehabi_accommodation_metaboxes(){
           
           add_meta_box(
                'nehabi_accommodation_gallery_metabox_id',      // ID
                'Accommodation Gallery',               // Title
                array( $this, 'nehabi_accommodation_gallery_metaboxes_template' ),
                'accommodation',                        // Post type (change to your CPT if needed)
                'side',                        // Context ('side' for right column)
                'default'                      // Priority
            );

        }


        public function nehabi_accommodation_gallery_metaboxes_template($post){
         
             
               $gallery_ids = get_post_meta($post->ID, '_photo_gallery_ids', true);
                $gallery_ids = is_array($gallery_ids) ? $gallery_ids : [];

                echo '<div id="photo-gallery-metabox" style="width:100%;">';
                echo '<div id="photo-gallery-wrapper" style="display:grid;grid-template-columns:repeat(3, 1fr);gap:2px;">';

                if (!empty($gallery_ids)) {
                    foreach ($gallery_ids as $id) {
                        $img_src = wp_get_attachment_image_src($id, 'thumbnail');
                        echo '<div class="photo-gallery-item" data-id="' . esc_attr($id) . '" style="position:relative;width:50px;">';
                        echo '<img src="' . esc_url($img_src[0]) . '" style="width:50px;height:auto;" />';
                        echo '<span class="remove-gallery-image" style="position:absolute;top:0;right:0;background:red;color:white;font-size:10px;padding:2px;cursor:pointer;">×</span>';
                        echo '</div>';
                    }
                }

                echo '</div>'; // photo-gallery-wrapper
                echo '<p><a href="#" id="add-gallery-link">Add gallery</a></p>';
                echo '<input type="hidden" id="photo-gallery-ids" name="photo_gallery_ids" value="' . esc_attr(implode(',', $gallery_ids)) . '">';
                echo '</div>'; // photo-gallery-metabox

             ?>
                 <script>
                    jQuery(document).ready(function($) {
                        var gallery_frame;

                        $('#add-gallery-link').on('click', function(e) {
                            e.preventDefault();

                            if (gallery_frame) {
                                gallery_frame.open();
                                return;
                            }

                            gallery_frame = wp.media({
                                title: 'Select Gallery Images',
                                button: { text: 'Add to Gallery' },
                                multiple: true
                            });

                            gallery_frame.on('select', function() {
                                var selection = gallery_frame.state().get('selection');
                                selection.map(function(attachment) {
                                    attachment = attachment.toJSON();
                                    var id = attachment.id;
                                    var thumb = '<div class="photo-gallery-item" data-id="' + id + '" style="position:relative;width:50px;">' +
                                                    '<img src="' + attachment.sizes.thumbnail.url + '" style="width:50px;height:auto;" />' +
                                                    '<span class="remove-gallery-image" style="position:absolute;top:0;right:0;background:red;color:white;font-size:10px;padding:2px;cursor:pointer;">×</span>' +
                                                '</div>';
                                    $('#photo-gallery-wrapper').append(thumb);
                                });

                                updateGalleryIds();
                            });

                            gallery_frame.open();
                        });

                        // Remove image
                        $(document).on('click', '.remove-gallery-image', function() {
                            $(this).closest('.photo-gallery-item').remove();
                            updateGalleryIds();
                        });

                        // Update hidden input
                        function updateGalleryIds() {
                            var ids = [];
                            $('#photo-gallery-wrapper .photo-gallery-item').each(function() {
                                ids.push($(this).data('id'));
                            });
                            $('#photo-gallery-ids').val(ids.join(','));
                        }
                    });
                    </script>
            <?php

        }



        /**
         * this function save the above input data
         */

         public function nehabi_accommodation_metaboxes_save($post_id){

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            if (!current_user_can('edit_post', $post_id)) return;

            if (isset($_POST['photo_gallery_ids'])) {
                $ids = array_filter(array_map('absint', explode(',', $_POST['photo_gallery_ids'])));
                update_post_meta($post_id, '_photo_gallery_ids', $ids);
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
                // unset($columns['date']);
                // unset($columns['title']);
                // if (isset($columns['taxonomy-branch_location'])) {
                //     // remove the branch location column if it exists
                //     unset($columns['taxonomy-branch_location']);

                //     }
              
              
                //unset($columns['subscription_price']);
            
                // $columns['post_id'] = __('ID', 'subscription_plan');     
                // $columns['title'] = __('Plan', 'subscription_plan');
                // $columns['subscription_price'] = __('Price', 'subscription_plan');
                // $columns['subscription_signup_fee'] = __('Sign Up Fee', 'subscription_plan');
                // $columns['subscription_free_trial'] = __('Free Trial', 'subscription_plan');
                // $columns['subscription_status'] = __('Status', 'subscription_plan');
                
                // $columns['date'] = __('Date', 'subscription_plan');
                
                // return $columns;


        } 

        /**
         * output Table column values
         */

         public function output_column_content($column, $post_id){
             
            // switch( $column ) {
               
                        
                    
            //     default:
            //         break;
            // }

        
         }
        

  
    }
    
 }