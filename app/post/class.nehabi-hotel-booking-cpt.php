<?php

if (!class_exists('Nehabi_Hotel_CPT')) {
    class Nehabi_Hotel_CPT {

        public function __construct() {
            add_action('init', array($this, 'register_booking_cpt'));  
            add_filter( 'manage_nehabi-hotel-booking_posts_columns', array($this,'wishu_booking_custom_columns') );
            add_action( 'manage_nehabi-hotel-booking_posts_custom_column',array($this,'wishu_booking_custom_column_content') , 10, 2 );
            add_filter( 'manage_edit-nehabi-hotel-booking_sortable_columns',array($this,'order_the_table'));


        }

        public function order_the_table( $columns ){
                    $columns['check_dates'] = 'checkin';
                    $columns['price']       = 'price';
                    return $columns;
                }

        public function register_booking_cpt() {
            register_post_type(
                'nehabi-hotel-booking',
                array(
                    'label' => __('Bookings', 'hotel-booking'),
                    'description' => __('Bookings', 'hotel-booking'),
                    'labels' => array(
                        'name' => __('Bookings', 'hotel-booking'),
                        'singular_name' => __('Booking', 'hotel-booking'),
                        'add_new' => __('Create New Booking', 'hotel-booking'),
                        'add_new_item' => __('Add New Booking', 'hotel-booking'),
                        'view_item' => __('View Booking', 'hotel-booking'),
                        'view_items' => __('View Bookings', 'hotel-booking'),
                        'featured_image' => __('Booking Image', 'hotel-booking'),
                        'set_featured_image' => __('Set Booking Image', 'hotel-booking'),
                        'remove_featured_image' => __('Remove Booking Image', 'hotel-booking'),
                        'use_featured_image' => __('Use as Booking Image', 'hotel-booking'),
                        'insert_into_item' => __('Insert into Booking', 'hotel-booking'),
                        'uploaded_to_this_item' => __('Uploaded to this Booking', 'hotel-booking'),
                        'items_list' => __('Booking List', 'hotel-booking'),
                        'items_list_navigation' => __('Booking List Navigation', 'hotel-booking'),
                        'filter_items_list' => __('Filter Booking List', 'hotel-booking'),
                        'archives' => __('Booking Archives', 'hotel-booking'),
                        'attributes' => __('Booking Attributes', 'hotel-booking'),
                        'parent_item_colon' => __('Parent Booking:', 'hotel-booking'),
                        'all_items' => __('All Bookings', 'hotel-booking'),
                        'new_item' => __('New Booking', 'hotel-booking'),
                        'edit_item' => __('Edit Booking', 'hotel-booking'),
                        'update_item' => __('Update Booking', 'hotel-booking'),
                        'search_items' => __('Search Booking', 'hotel-booking'),
                        'not_found' => __('Not found', 'hotel-booking'),
                        'not_found_in_trash' => __('Not found in Trash', 'hotel-booking'),
                    ),
                    'public' => true,
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'hierarchical' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => true,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                    'menu_icon' => 'dashicons-calendar-alt',
                )
            );
        }


       public function wishu_booking_custom_columns( $columns ) {
            unset( $columns['date'] ); // Optional: remove default date column
            $columns['status']       = 'Status';
            $columns['check_dates']  = 'Check-in / Check-out';
            // $columns['guests']       = 'Guests';
            $columns['customer_info']= 'Customer Info';
            $columns['price']        = 'Price';
            $columns['accommodation']= 'Accommodation';
            $columns['date']         = 'Date'; // Keep Date at the end
            return $columns;
        }


        public function wishu_booking_custom_column_content( $column, $post_id ) {
            $order_id = get_post_meta( $post_id, 'order_id', true );
            
            if ( ! $order_id ) return;

            $order = wc_get_order( $order_id );
            $order = wc_get_order( $order_id );


            if ( ! $order ) return;

            switch( $column ) {
                case 'status':
                $current_status = $order->get_status(); // e.g. "processing"
                $statuses = wc_get_order_statuses(); ?>

                <select class="order-status-select" data-order-id="<?php echo esc_attr( $order_id ); ?>">
                    <?php foreach ( $statuses as $status_key => $status_label ) : 
                        // convert "wc-processing" to "processing" for comparison
                        $key_slug = str_replace('wc-', '', $status_key); ?>
                        
                        <option value="<?php echo esc_attr( $status_key ); ?>" <?php selected( $current_status, $key_slug ); ?>>
                            <?php echo esc_html( $status_label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php
                break;

                case 'check_dates':
                    foreach ( $order->get_items() as $item_id => $item ) {
                            $accommodation_id = $item->get_meta('accommodation_id');
                            $check_in         = $item->get_meta('Check-in');
                            $check_out        = $item->get_meta('Check-out');
                        }
                
                    echo $check_in && $check_out ? esc_html( $check_in . ' / ' . $check_out ) : '-';
                    break;

                case 'customer_info':
                    echo esc_html( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
                    echo '<br>' . esc_html( $order->get_billing_email() );
                    break;

                case 'price':
                    echo wc_price( $order->get_total() );
                    break;

                case 'accommodation':
                    foreach ( $order->get_items() as $item_id => $item ) {
                            $accommodation_id = $item->get_meta('accommodation_id');
                        }
                    
                    if ( $accommodation_id ) {
                        $acc_post = get_post( $accommodation_id );
                        echo $acc_post ? esc_html( $acc_post->post_title ) : esc_html( $accommodation_id );
                    } else {
                        echo '-';
                    }
                    break;

                // Optional guests column if needed
                // case 'guests':
                //     $guests = $order->get_meta( 'guests' );
                //     echo $guests ? esc_html( $guests ) : '-';
                //     break;
            }
        }
    }
}
