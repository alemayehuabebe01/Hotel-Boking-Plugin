<?php

if (!class_exists('Nehabi_Hotel_Settings')) {
    class Nehabi_Hotel_Settings {
        public static $options;

        public function __construct() {
            self::$options = get_option('nehabi_hotel_options');

            add_action('admin_init', [$this, 'admin_init']);
        }

         

        public function admin_init() {
            register_setting(
                'nehabi_hotel_group',
                'nehabi_hotel_options'
            );

            add_settings_section(
                'nehabi_search_page',
                '#Page',
                '__return_null',
                'nehabi_search_page_section'
            );

            add_settings_field(
                'nehabi_hotel_search_page',
                'Search Results Page',
                [$this, 'nehabi_hotel_search_page_callback'],
                'nehabi_search_page_section',
                'nehabi_search_page'
            );

            add_settings_field(
                'nehabi_hotel_checkout_page',
                'Checkout Page',
                [$this, 'nehabi_hotel_checkout_page_callback'],
                'nehabi_search_page_section',
                'nehabi_search_page'
            );
        }

        public function nehabi_hotel_checkout_page_callback(){
            $selected = isset(self::$options['nehabi_hotel_checkout_page']) ? self::$options['nehabi_hotel_checkout_page'] : '';
            $pages = get_pages();

            echo '<select name="nehabi_hotel_options[nehabi_hotel_checkout_page]">';
            echo '<option value="">— Select a Page —</option>';

            foreach ($pages as $page) {
                $is_selected = selected($selected, $page->ID, false);
                echo '<option value="' . esc_attr($page->ID) . '" ' . $is_selected . '>' . esc_html($page->post_title) . '</option>';
            }

            echo '</select>';
            echo '<p class="description">Select page user will be redirected to complete booking.</p>';
        }

        public function nehabi_hotel_search_page_callback() {
            $selected = isset(self::$options['nehabi_hotel_search_page']) ? self::$options['nehabi_hotel_search_page'] : '';
            $pages = get_pages();

            echo '<select name="nehabi_hotel_options[nehabi_hotel_search_page]">';
            echo '<option value="">— Select a Page —</option>';

            foreach ($pages as $page) {
                $is_selected = selected($selected, $page->ID, false);
                echo '<option value="' . esc_attr($page->ID) . '" ' . $is_selected . '>' . esc_html($page->post_title) . '</option>';
            }

            echo '</select>';
            echo '<p class="description">Select page to display search results. Use <code>[search_results]</code> shortcode on this page.</p>';
        }

         
    }

}
