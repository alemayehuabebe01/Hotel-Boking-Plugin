<?php

if( ! class_exists('Nehabi_Season_Metaboxes') ){

    class Nehabi_Season_Metaboxes {
        
        public function __construct(){
            add_action( 'add_meta_boxes', array( $this , 'nehabi_season_metaboxes' ) );
            add_action( 'save_post', array( $this , 'nehabi_season_metaboxes_save' ) );
            add_action('admin_enqueue_scripts', array($this, 'enqueue_season_admin_assets'));
            add_action( 'manage_nh_seasons_posts_columns', array( $this, 'add_columns' ) );
            add_filter('manage_nh_seasons_posts_custom_column', array($this, 'output_column_content'),10,2 );
        }

        public function enqueue_season_admin_assets($hook) {
            $screen = get_current_screen();
            if ($screen->post_type == 'nh_seasons' && in_array($hook, array('post-new.php', 'post.php'))) {
                wp_enqueue_script( 'jquery-ui-datepicker' );
                wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
                ?>
                <style>
                    .form-table th {
                        width: 200px;
                        padding: 10px 10px 10px 0;
                        text-align: left;
                        vertical-align: top;
                    }
                    .form-table td {
                        padding: 10px 0;
                    }
                    .datepicker {
                        width: 250px;
                    }
                    select[multiple] {
                        min-width: 250px;
                        min-height: 140px;
                    }
                </style>
                <?php
            }
        }

        public function nehabi_season_metaboxes(){
            add_meta_box(
                'nehabi_season_metabox_id',
                'Season Info',
                array( $this, 'nehabi_season_metabox_template' ),
                'nh_seasons',
                'normal',
                'high'
            );
        }
            
        public function nehabi_season_metabox_template($post){
            wp_nonce_field('nehabi_season_nonce_action', 'nehabi_season_nonce');

            $start_date = get_post_meta($post->ID, '_season_start_date', true);
            $end_date   = get_post_meta($post->ID, '_season_end_date', true);
            $applied_days = get_post_meta($post->ID, '_season_applied_days', true) ?: [];
            $repeat     = get_post_meta($post->ID, '_season_repeat', true);
            $repeat_until = get_post_meta($post->ID, '_season_repeat_until', true);

            $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            ?>
            <table class="form-table">
                <tr>
                    <th><label for="season_start_date">Start date <span style="color:red;">*</span></label></th>
                    <td><input type="text" id="season_start_date" name="season_start_date" value="<?php echo esc_attr($start_date); ?>" class="datepicker" /></td>
                </tr>
                <tr>
                    <th><label for="season_end_date">End date <span style="color:red;">*</span></label></th>
                    <td><input type="text" id="season_end_date" name="season_end_date" value="<?php echo esc_attr($end_date); ?>" class="datepicker" /></td>
                </tr>
                <tr>
                    <th><label for="season_applied_days">Applied for days <span style="color:red;">*</span></label></th>
                    <td>
                        <select name="season_applied_days[]" id="season_applied_days" multiple>
                            <?php foreach($days as $day): ?>
                                <option value="<?php echo esc_attr($day); ?>" <?php selected(in_array($day, $applied_days)); ?>>
                                    <?php echo esc_html($day); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p style="font-size:12px;color:#666;">Hold Ctrl / Cmd to select multiple.</p>
                    </td>
                </tr>
                <tr>
                    <th>Repeat</th>
                    <td>
                        <label><input type="radio" name="season_repeat" value="none" <?php checked($repeat, 'none'); ?> /> Does not repeat</label><br>
                        <label><input type="radio" name="season_repeat" value="annually" <?php checked($repeat, 'annually'); ?> /> Annually</label>
                        <p style="font-size:12px;color:#666;">Annual repeats begin on the Start date of the season, for one year from the current date.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="season_repeat_until">Repeat until date</label></th>
                    <td><input type="text" id="season_repeat_until" name="season_repeat_until" value="<?php echo esc_attr($repeat_until); ?>" class="datepicker" /></td>
                </tr>
            </table>

            <script>
                jQuery(document).ready(function($) {
                    $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
                });
            </script>
            <?php
        }

        public function nehabi_season_metaboxes_save($post_id){
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            if (!isset($_POST['nehabi_season_nonce']) || !wp_verify_nonce($_POST['nehabi_season_nonce'], 'nehabi_season_nonce_action')) return;

            update_post_meta($post_id, '_season_start_date', sanitize_text_field($_POST['season_start_date'] ?? ''));
            update_post_meta($post_id, '_season_end_date', sanitize_text_field($_POST['season_end_date'] ?? ''));
            update_post_meta($post_id, '_season_applied_days', array_map('sanitize_text_field', $_POST['season_applied_days'] ?? []));
            update_post_meta($post_id, '_season_repeat', sanitize_text_field($_POST['season_repeat'] ?? 'none'));
            update_post_meta($post_id, '_season_repeat_until', sanitize_text_field($_POST['season_repeat_until'] ?? ''));
        }

        public function nehabi_member_subscription_values(){
             if( isset($value) && ! empty($value) ){
                return $value;
             }else{
                return '';
             }
        }

         public function add_columns( $columns ){

            /**
             * to overide the default columns
             */
              unset($columns['date']);
              unset($columns['title']);
              
              
              
              //unset($columns['subscription_price']);
         
                
            $columns['title'] = __('Title', 'nh_seasons');
            $columns['_season_start_date'] = __('Start Date', 'nh_seasons');
            $columns['end_date'] = __('End Date', 'nh_seasons');
            $columns['applied_days'] = __('Applied Days', 'nh_seasons');
            $columns['repeat'] = __('Repeat', 'nh_seasons');
            $columns['date'] = __('Date', 'nh_seasons');
            
            return $columns;


        } 


         public function output_column_content($column, $post_id){
             
            switch( $column ) {
                 case '_season_start_date':
                    $start_date = get_post_meta($post_id, '_season_start_date', true);
                    echo esc_html($start_date ? date_i18n(get_option('date_format'), strtotime($start_date)): 'N/A');
                    break;
                case 'end_date':
                    $end_date = get_post_meta($post_id, '_season_end_date', true);
                    echo esc_html($end_date ? date_i18n(get_option('date_format'), strtotime($end_date)): 'N/A');
                    break;
                case 'applied_days':
                    $applied_days = get_post_meta($post_id, '_season_applied_days', true);
                    if (is_array($applied_days) && !empty($applied_days)) {
                        echo esc_html(implode(', ', array_map('sanitize_text_field', $applied_days)));
                    } else {
                        echo esc_html('N/A');
                    }
                    break;
                case 'repeat':
                    $season_repeat = get_post_meta($post_id, '_season_repeat', true);
                    if ($season_repeat === 'annually') {
                        echo esc_html('Annually');
                    } elseif ($season_repeat === 'none') {
                        echo esc_html('Does not repeat');
                    } else {
                        echo esc_html('N/A');
                    }
                    break;
                    
                default:
                    break;
            }

        
         }

    }
}

 
