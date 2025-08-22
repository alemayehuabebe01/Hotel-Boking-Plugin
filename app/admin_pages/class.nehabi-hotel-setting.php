<?php

if (!class_exists('Nehabi_Hotel_Settings')) {
    class Nehabi_Hotel_Settings {
        public static $options, $email_options;

        public function __construct() {
            self::$options = get_option('nehabi_hotel_options');
            self::$email_options = get_option('nehabi_hotel_email_options');
            add_action('admin_init', [$this, 'admin_init']);
        }

         

        public function admin_init() {
            register_setting(
                'nehabi_hotel_group',
                'nehabi_hotel_options'
            );

            register_setting(
                'nehabi_hotel_email_group',
                'nehabi_hotel_email_options',
                [$this, 'sanitize_email_options']
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

            // Email Setting Sections
            add_settings_section(
                'nehabi_email_settings',
                'Email Settings',
                '__return_null',
                'nehabi_email_settings_section'
            );

            // Email template fields
            add_settings_field(
                'nehabi_comformation_email',
                'Booking Confirmation Email',
                [$this, 'nehabi_comformation_email_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_settings'
            );

            add_settings_field(
                'nehabi_cancel_email',
                'Booking Cancel Email',
                [$this, 'nehabi_cancel_email_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_settings'
            );

            add_settings_field(
                'nehabi_pendig_email',
                'Booking Pending Email',
                [$this, 'nehabi_pendig_email_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_settings'
            );

            add_settings_field(
                'nehabi_expired_email',
                'Booking Expired Email',
                [$this, 'nehabi_expired_email_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_settings'
            );

            // Email design settings
            add_settings_section(
                'nehabi_email_design',
                'Email Design Settings',
                '__return_null',
                'nehabi_email_settings_section'
            );

            add_settings_field(
                'nehabi_email_primary_color',
                'Primary Color',
                [$this, 'nehabi_email_primary_color_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_design'
            );

            add_settings_field(
                'nehabi_email_secondary_color',
                'Secondary Color',
                [$this, 'nehabi_email_secondary_color_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_design'
            );

            add_settings_field(
                'nehabi_email_background_color',
                'Background Color',
                [$this, 'nehabi_email_background_color_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_design'
            );

            add_settings_field(
                'nehabi_email_text_color',
                'Text Color',
                [$this, 'nehabi_email_text_color_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_design'
            );

            add_settings_field(
                'nehabi_email_header',
                'Email Header',
                [$this, 'nehabi_email_header_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_design'
            );

            add_settings_field(
                'nehabi_email_footer',
                'Email Footer',
                [$this, 'nehabi_email_footer_callback'],
                'nehabi_email_settings_section',
                'nehabi_email_design'
            );
        }

        public function sanitize_email_options($input) {
            $sanitized_input = [];
            
            // Sanitize color values
            $sanitized_input['primary_color'] = sanitize_hex_color($input['primary_color']);
            $sanitized_input['secondary_color'] = sanitize_hex_color($input['secondary_color']);
            $sanitized_input['background_color'] = sanitize_hex_color($input['background_color']);
            $sanitized_input['text_color'] = sanitize_hex_color($input['text_color']);
            
            // Sanitize template content
            $sanitized_input['confirmation_template'] = wp_kses_post($input['confirmation_template']);
            $sanitized_input['cancellation_template'] = wp_kses_post($input['cancellation_template']);
            $sanitized_input['pending_template'] = wp_kses_post($input['pending_template']);
            $sanitized_input['expired_template'] = wp_kses_post($input['expired_template']);
            
            // Sanitize header and footer
            $sanitized_input['email_header'] = wp_kses_post($input['email_header']);
            $sanitized_input['email_footer'] = wp_kses_post($input['email_footer']);
            
            return $sanitized_input;
        }

        public function nehabi_email_primary_color_callback() {
            $color = isset(self::$email_options['primary_color']) ? self::$email_options['primary_color'] : '#3498db';
            echo '<input type="text" name="nehabi_hotel_email_options[primary_color]" value="' . esc_attr($color) . '" class="nehabi-color-picker" data-default-color="#3498db" />';
        }

        public function nehabi_email_secondary_color_callback() {
            $color = isset(self::$email_options['secondary_color']) ? self::$email_options['secondary_color'] : '#2ecc71';
            echo '<input type="text" name="nehabi_hotel_email_options[secondary_color]" value="' . esc_attr($color) . '" class="nehabi-color-picker" data-default-color="#2ecc71" />';
        }

        public function nehabi_email_background_color_callback() {
            $color = isset(self::$email_options['background_color']) ? self::$email_options['background_color'] : '#f8f9fa';
            echo '<input type="text" name="nehabi_hotel_email_options[background_color]" value="' . esc_attr($color) . '" class="nehabi-color-picker" data-default-color="#f8f9fa" />';
        }

        public function nehabi_email_text_color_callback() {
            $color = isset(self::$email_options['text_color']) ? self::$email_options['text_color'] : '#333333';
            echo '<input type="text" name="nehabi_hotel_email_options[text_color]" value="' . esc_attr($color) . '" class="nehabi-color-picker" data-default-color="#333333" />';
        }

        public function nehabi_email_header_callback() {
            $header = isset(self::$email_options['email_header']) ? self::$email_options['email_header'] : '<h1 style="color: {primary_color}; text-align: center;">Booking Notification</h1>';
            wp_editor($header, 'nehabi_email_header', [
                'textarea_name' => 'nehabi_hotel_email_options[email_header]',
                'textarea_rows' => 5,
                'media_buttons' => false
            ]);
            echo '<p class="description">Use {primary_color} to automatically use the primary color.</p>';
        }

        public function nehabi_email_footer_callback() {
            $footer = isset(self::$email_options['email_footer']) ? self::$email_options['email_footer'] : '<p style="text-align: center; color: #777; font-size: 12px;">&copy; ' . date('Y') . ' Your Hotel. All rights reserved.</p>';
            wp_editor($footer, 'nehabi_email_footer', [
                'textarea_name' => 'nehabi_hotel_email_options[email_footer]',
                'textarea_rows' => 5,
                'media_buttons' => false
            ]);
        }

        public function nehabi_comformation_email_callback() {
            $template = isset(self::$email_options['confirmation_template']) ? self::$email_options['confirmation_template'] : $this->get_default_confirmation_template();
            wp_editor($template, 'nehabi_confirmation_email', [
                'textarea_name' => 'nehabi_hotel_email_options[confirmation_template]',
                'textarea_rows' => 12,
                'media_buttons' => true
            ]);
            echo '<p class="description">Available variables: {customer_name}, {booking_id}, {check_in_date}, {check_out_date}, {room_type}, {total_amount}</p>';
        }

        public function nehabi_cancel_email_callback() {
            $template = isset(self::$email_options['cancellation_template']) ? self::$email_options['cancellation_template'] : $this->get_default_cancellation_template();
            wp_editor($template, 'nehabi_cancel_email', [
                'textarea_name' => 'nehabi_hotel_email_options[cancellation_template]',
                'textarea_rows' => 12,
                'media_buttons' => true
            ]);
            echo '<p class="description">Available variables: {customer_name}, {booking_id}, {check_in_date}, {check_out_date}, {room_type}</p>';
        }

        public function nehabi_pendig_email_callback() {
            $template = isset(self::$email_options['pending_template']) ? self::$email_options['pending_template'] : $this->get_default_pending_template();
            wp_editor($template, 'nehabi_pending_email', [
                'textarea_name' => 'nehabi_hotel_email_options[pending_template]',
                'textarea_rows' => 12,
                'media_buttons' => true
            ]);
            echo '<p class="description">Available variables: {customer_name}, {booking_id}, {check_in_date}, {check_out_date}, {room_type}, {total_amount}</p>';
        }

        public function nehabi_expired_email_callback() {
            $template = isset(self::$email_options['expired_template']) ? self::$email_options['expired_template'] : $this->get_default_expired_template();
            wp_editor($template, 'nehabi_expired_email', [
                'textarea_name' => 'nehabi_hotel_email_options[expired_template]',
                'textarea_rows' => 12,
                'media_buttons' => true
            ]);
            echo '<p class="description">Available variables: {customer_name}, {booking_id}, {check_in_date}, {check_out_date}, {room_type}</p>';
        }

        // Default templates
        private function get_default_confirmation_template() {
            return '<div style="background-color: {background_color}; padding: 20px; font-family: Arial, sans-serif; color: {text_color};">
    {email_header}
    <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h2 style="color: {primary_color};">Booking Confirmed!</h2>
        <p>Dear {customer_name},</p>
        <p>Your booking has been confirmed. Below are your booking details:</p>
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Booking ID</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{booking_id}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Check-in Date</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{check_in_date}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Check-out Date</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{check_out_date}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Room Type</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{room_type}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Total Amount</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{total_amount}</td>
            </tr>
        </table>
        <p>We look forward to hosting you!</p>
    </div>
    {email_footer}
</div>';
        }

        private function get_default_cancellation_template() {
            return '<div style="background-color: {background_color}; padding: 20px; font-family: Arial, sans-serif; color: {text_color};">
    {email_header}
    <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h2 style="color: {primary_color};">Booking Cancelled</h2>
        <p>Dear {customer_name},</p>
        <p>Your booking (ID: {booking_id}) has been cancelled.</p>
        <p>If this was a mistake or you need further assistance, please contact us.</p>
    </div>
    {email_footer}
</div>';
        }

        private function get_default_pending_template() {
            return '<div style="background-color: {background_color}; padding: 20px; font-family: Arial, sans-serif; color: {text_color};">
    {email_header}
    <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h2 style="color: {primary_color};">Booking Pending</h2>
        <p>Dear {customer_name},</p>
        <p>Your booking is currently pending confirmation. We will notify you once it\'s confirmed.</p>
        <p>Booking details:</p>
        <ul>
            <li>Booking ID: {booking_id}</li>
            <li>Check-in: {check_in_date}</li>
            <li>Check-out: {check_out_date}</li>
            <li>Room Type: {room_type}</li>
            <li>Total Amount: {total_amount}</li>
        </ul>
    </div>
    {email_footer}
</div>';
        }

        private function get_default_expired_template() {
            return '<div style="background-color: {background_color}; padding: 20px; font-family: Arial, sans-serif; color: {text_color};">
    {email_header}
    <div style="background: white; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h2 style="color: {primary_color};">Booking Expired</h2>
        <p>Dear {customer_name},</p>
        <p>Your pending booking (ID: {booking_id}) has expired because we didn\'t receive confirmation in time.</p>
        <p>If you still wish to book, please visit our website again.</p>
    </div>
    {email_footer}
</div>';
        }

        public function nehabi_hotel_checkout_page_callback() {
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