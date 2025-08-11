<?php
if (!class_exists('Nehabi_Accommodation_Season_Pricing')) {

    class Nehabi_Accommodation_Season_Pricing {

        public function __construct() {
            add_action('add_meta_boxes', [$this, 'register_season_price_metabox']);
            add_action('save_post_accommodation', [$this, 'save_season_prices']);
        }

        /**
         * Register Metabox
         */
        public function register_season_price_metabox() {
            add_meta_box(
                'accommodation_season_prices',
                __('Season Prices', 'hotel-booking'),
                [$this, 'render_season_price_metabox'],
                'accommodation',
                'normal',
                'default'
            );
        }

        /**
         * Render Metabox Fields
         */
        public function render_season_price_metabox($post) {
            wp_nonce_field('save_accommodation_season_prices', 'accommodation_season_prices_nonce');

            $season_prices = get_post_meta($post->ID, '_season_prices', true) ?: [];

            $seasons = get_posts([
                'post_type'      => 'nh_seasons',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);

            echo '<table class="form-table" style="width:100%;">';
            echo '<tr><th style="text-align:left;">Season</th><th>Price Type</th><th>Value</th></tr>';

            foreach ($seasons as $season) {
                $price_type  = $season_prices[$season->ID]['type'] ?? 'fixed';
                $price_value = $season_prices[$season->ID]['value'] ?? '';

                echo '<tr>';
                echo '<td style="width:40%;"><label>' . esc_html($season->post_title) . '</label></td>';
                echo '<td style="width:30%;">
                        <select name="season_prices[' . $season->ID . '][type]" style="width:100%;">
                            <option value="fixed" ' . selected($price_type, 'fixed', false) . '>Fixed</option>
                            <option value="percentage" ' . selected($price_type, 'percentage', false) . '>Percentage</option>
                        </select>
                      </td>';
                echo '<td style="width:30%;">
                        <input type="number" step="0.01" name="season_prices[' . $season->ID . '][value]" 
                            value="' . esc_attr($price_value) . '" style="width:100%;">
                      </td>';
                echo '</tr>';
            }

            echo '</table>';
        }

        /**
         * Save Season Prices
         */
        public function save_season_prices($post_id) {
            if (!isset($_POST['accommodation_season_prices_nonce']) ||
                !wp_verify_nonce($_POST['accommodation_season_prices_nonce'], 'save_accommodation_season_prices')) {
                return;
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

            if (isset($_POST['season_prices']) && is_array($_POST['season_prices'])) {
                $cleaned = [];
                foreach ($_POST['season_prices'] as $season_id => $data) {
                    $cleaned[$season_id] = [
                        'type'  => sanitize_text_field($data['type']),
                        'value' => floatval($data['value'])
                    ];
                }
                update_post_meta($post_id, '_season_prices', $cleaned);
            }
        }

        /**
         * Get Calculated Price Based on Season
         */
        public function get_price_for_date($accommodation_id, $date) {
            $base_price    = floatval(get_post_meta($accommodation_id, '_base_price', true));
            $season_prices = get_post_meta($accommodation_id, '_season_prices', true) ?: [];

            $active_season_id = $this->get_active_season_id($date);

            if ($active_season_id && isset($season_prices[$active_season_id])) {
                $price_type  = $season_prices[$active_season_id]['type'];
                $price_value = $season_prices[$active_season_id]['value'];

                if ($price_type === 'fixed') {
                    return $price_value;
                } elseif ($price_type === 'percentage') {
                    return $base_price + ($base_price * ($price_value / 100));
                }
            }

            return $base_price; // fallback to base price if no match
        }

        /**
         * Determine Active Season by Date
         * (You need to replace this with actual season date range check)
         */
        private function get_active_season_id($date) {
            $seasons = get_posts([
                'post_type'      => 'season',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ]);

            foreach ($seasons as $season) {
                $start_date = get_post_meta($season->ID, '_season_start_date', true);
                $end_date   = get_post_meta($season->ID, '_season_end_date', true);

                if ($date >= $start_date && $date <= $end_date) {
                    return $season->ID;
                }
            }

            return false;
        }

    }
}


