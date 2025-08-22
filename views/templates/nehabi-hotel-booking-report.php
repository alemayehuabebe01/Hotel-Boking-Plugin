<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Analytics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
       
        
        .wrap {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Header Styles */
        .wp-heading-inline {
            font-size: 23px;
            font-weight: 400;
            padding: 9px 0 4px;
            display: inline-block;
            margin-right: 5px;
            color: #1d2327;
        }
        
        .dashicons-chart-bar {
            color: #2271b1;
            margin-right: 10px;
        }
        
        .page-title-action {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            font-size: 14px;
            height: 36px;
            padding: 0 12px;
            background: #2271b1;
            color: #fff;
            border: 1px solid #2271b1;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 5px;
            transition: all 0.15s ease-in-out;
        }
        
        .page-title-action:hover {
            background: #135e96;
            border-color: #135e96;
            color: #fff;
        }
        
        .page-title-action i {
            margin-right: 5px;
        }
        
        .wp-header-end {
            margin: 15px 0;
            border: none;
            border-top: 1px solid #dcdcde;
        }
        
        /* KPI Cards */
        .booking-kpis {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .kpi-card {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.2s;
        }
        
        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        
        .kpi-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .kpi-content {
            display: flex;
            flex-direction: column;
        }
        
        .kpi-title {
            font-size: 14px;
            color: #646970;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .kpi-number {
            font-size: 24px;
            font-weight: 600;
            color: #1d2327;
        }
        
        /* Card Styles */
        .card {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
            margin-bottom: 20px;
        }
        
        .card-header {
            padding: 16px 24px;
            border-bottom: 1px solid #dcdcde;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1d2327;
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .card-title i {
            margin-right: 10px;
            color: #2271b1;
        }
        
        .card-body {
            padding: 24px;
        }
        
        /* Filter Styles */
        .filter-card {
            margin-bottom: 20px;
        }
        
        .filters-title {
            font-size: 16px;
            font-weight: 600;
            color: #1d2327;
            margin: 0;
        }
        
        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: end;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-group label {
            font-weight: 500;
            font-size: 14px;
        }
        
        select, input[type="date"] {
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 14px;
            line-height: 1.5;
            height: 40px;
        }
        
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            height: 40px;
            padding: 0 12px;
            background: #2271b1;
            color: #fff;
            border: 1px solid #2271b1;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
        }
        
        .button:hover {
            background: #135e96;
            border-color: #135e96;
            color: #fff;
        }
        
        .date-range-group {
            display: none;
        }
        
        /* Charts Row */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .chart-card {
            height: 400px;
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }
        
        .wp-list-table {
            border-radius: 8px;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #c3c4c7;
        }
        
        .wp-list-table th {
            font-weight: 600;
            background: #f6f7f7;
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #c3c4c7;
        }
        
        .wp-list-table td {
            padding: 12px;
            border-bottom: 1px solid #dcdcde;
        }
        
        .wp-list-table tr:last-child td {
            border-bottom: none;
        }
        
        .wp-list-table tr:hover {
            background-color: #f0f6fc;
        }
        
        /* Recommendations Section */
        .recommendations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .recommendation-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .recommendation-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
            color: #fff;
        }
        
        .recommendation-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #1d2327;
        }
        
        .recommendation-content {
            flex-grow: 1;
        }
        
        .recommendation-content p {
            margin-bottom: 15px;
            color: #646970;
        }
        
        .recommendation-metrics {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        .metric {
            display: flex;
            flex-direction: column;
        }
        
        .metric-value {
            font-size: 18px;
            font-weight: 600;
            color: #2271b1;
        }
        
        .metric-label {
            font-size: 12px;
            color: #646970;
        }
        
        /* Responsive Styles */
        @media screen and (max-width: 782px) {
            .booking-kpis {
                grid-template-columns: 1fr;
            }
            
            .charts-row {
                grid-template-columns: 1fr;
            }
            
            .filter-form {
                grid-template-columns: 1fr;
            }
            
            .chart-card {
                height: 300px;
            }
            
            .recommendations-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <i class="fas fa-chart-bar"></i> Booking Analytics
        </h1>
        <a href="#" class="page-title-action">
            <i class="fas fa-file-export"></i> Export CSV
        </a>
        <hr class="wp-header-end">

        <!-- KPI Cards -->
        <div class="booking-kpis">
            <div class="kpi-card">
                <div class="kpi-icon" style="background-color: rgba(0,115,170,0.2); color: #0073aa;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <?php

                global $wpdb;

                $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

                $total_revenue = $wpdb->get_var( 
                    $wpdb->prepare(
                        "SELECT SUM(payment_total) 
                        FROM $table_name 
                        WHERE status = %s", 
                        'completed' 
                    ) 
                );
                $currency_symbol = get_woocommerce_currency_symbol();
                $formatted_revenue = $currency_symbol . number_format( (float) $total_revenue, 2 );
                ?>

                <div class="kpi-content">
                    <span class="kpi-title">Total Revenue</span>
                    <span class="kpi-number"><?php echo $formatted_revenue; ?></span>
                </div>
            </div>
            
            <div class="kpi-card">
                <div class="kpi-icon" style="background-color: rgba(70,180,80,0.2); color: #46b450;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <?php
                global $wpdb;
                    $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

                    $total_count = $wpdb->get_var( 
                        $wpdb->prepare(
                            "SELECT COUNT(*) 
                            FROM $table_name 
                            WHERE status = %s", 
                            'completed' 
                        ) 
                    );

                     
                ?>

                    <div class="kpi-content">
                        <span class="kpi-title">Total Bookings</span>
                        <span class="kpi-number"><?php echo   $total_count; ?></span>
                    </div>
            </div>
            
            <div class="kpi-card">
                <div class="kpi-icon" style="background-color: rgba(255,185,0,0.2); color: #ffb900;">
                    <i class="fas fa-clock"></i>
                </div>

                <?php
                global $wpdb;
                    $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

                    $total_pending_count = $wpdb->get_var( 
                        $wpdb->prepare(
                            "SELECT COUNT(*) 
                            FROM $table_name 
                            WHERE status = %s", 
                            'Pending' 
                        ) 
                    );

                     
                ?>


                <div class="kpi-content">
                    <span class="kpi-title">Pending</span>
                    <span class="kpi-number"><?php echo  $total_pending_count; ?></span>
                </div>
            </div>
            
            <div class="kpi-card">
                <div class="kpi-icon" style="background-color: rgba(220,50,50,0.2); color: #dc3232;">
                    <i class="fas fa-times-circle"></i>
                </div>

                <?php
                global $wpdb;
                    $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

                    $total_cancelled_count = $wpdb->get_var( 
                        $wpdb->prepare(
                            "SELECT COUNT(*) 
                            FROM $table_name 
                            WHERE status = %s", 
                            'Cancelled' 
                        ) 
                    );

                     
                ?>


                <div class="kpi-content">
                    <span class="kpi-title">Cancelled</span>
                    <span class="kpi-number"><?php echo $total_cancelled_count; ?></span>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="charts-row">
            <!-- Revenue Trend -->
            <div class="chart-card">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-line-chart"></i> Revenue Trend</h2>
                </div>

                <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

                    // Get revenue for last 7 days (grouped by day)
                    $results = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT DATE(created_at) as date, SUM(payment_total) as total
                            FROM $table_name
                            WHERE status = %s 
                            AND created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                            GROUP BY DATE(created_at)
                            ORDER BY date ASC",
                            'completed'
                        )
                    );

                    // Build arrays for labels and data
                    $labels = [];
                    $data   = [];

                    // Fill 7 days even if no revenue that day
                    $period = new DatePeriod(
                        new DateTime('-6 days'),
                        new DateInterval('P1D'),
                        new DateTime('+1 day')
                    );

                    foreach ($period as $day) {
                        $date = $day->format('Y-m-d');
                        $labels[] = $day->format('D'); // Mon, Tue, etc.

                        // Find matching result
                        $found = false;
                        foreach ($results as $row) {
                            if ($row->date === $date) {
                                $data[] = (float) $row->total;
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $data[] = 0; // No revenue that day
                        }
                    }
                    ?>
                <div class="card-body">
                    <canvas id="revenueChart" height="250"></canvas>
                </div>
            </div>

            <!-- Bookings by Status -->
            <div class="chart-card">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-chart-pie"></i> Bookings by Status</h2>
                </div>

                <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

                    // Get counts for each status
                    $confirmed = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE status = %s", 'completed') );
                    $pending   = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE status = %s", 'pending') );
                    $cancelled = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE status = %s", 'cancelled') );
                    $abandoned = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE status = %s", 'abandoned') );
                    ?>
                <div class="card-body">
                    <canvas id="statusChart" height="250"></canvas>
                </div>
            </div>
            
        </div>

        <!-- Top Accommodations -->
       <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

            // Get top accommodations by revenue
            $results = $wpdb->get_results("
                SELECT accommodation_id,
                    COUNT(*) AS total_bookings,
                    SUM(payment_total) AS total_revenue,
                    ROUND(AVG(payment_total), 2) AS avg_rate
                FROM $table_name
                WHERE status = 'completed'
                GROUP BY accommodation_id
                ORDER BY total_revenue DESC
                LIMIT 10
            ");
            ?>

            <div class="">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-bed"></i> Top Accommodations</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th>Accommodation</th>
                                    <th>Bookings</th>
                                    <th>Revenue</th>
                                    <th>Avg. Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ( $results ) : ?>
                                    <?php foreach ( $results as $row ) : 
                                        $accommodation_name = get_the_title($row->accommodation_id); 
                                    ?>
                                        <tr>
                                            <td><?php echo esc_html($accommodation_name); ?></td>
                                            <td><?php echo (int) $row->total_bookings; ?></td>
                                            <td><?php echo wc_price( $row->total_revenue ); ?></td>
                                            <td><?php echo wc_price( $row->avg_rate ); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4">No completed bookings found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <!-- Recommendations Section -->
        <div class="">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-lightbulb"></i> Recommendations</h2>
            </div>
            <div class="card-body">
                <div class="recommendations-grid">
                    <div class="recommendation-card">
                        <div class="recommendation-icon" style="background-color: #00a0d2;">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="recommendation-content">
                            <h3 class="recommendation-title">Promote Luxury Suites</h3>
                            <p>Your Luxury Suites have the highest revenue per booking. Consider creating a marketing campaign to highlight these premium options.</p>
                            <div class="recommendation-metrics">
                                <div class="metric">
                                    <span class="metric-value">₹280</span>
                                    <span class="metric-label">Avg. Rate</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">92%</span>
                                    <span class="metric-label">Occupancy</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recommendation-card">
                        <div class="recommendation-icon" style="background-color: #46b450;">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div class="recommendation-content">
                            <h3 class="recommendation-title">Reduce Cancellations</h3>
                            <p>Your cancellation rate is 5.4%. Consider implementing a more flexible cancellation policy or offering incentives for non-refundable bookings.</p>
                            <div class="recommendation-metrics">
                                <div class="metric">
                                    <span class="metric-value">5.4%</span>
                                    <span class="metric-label">Cancel Rate</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">₹420</span>
                                    <span class="metric-label">Lost Revenue</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recommendation-card">
                        <div class="recommendation-icon" style="background-color: #ffb900;">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="recommendation-content">
                            <h3 class="recommendation-title">Weekend Promotion</h3>
                            <p>Weekends show 35% higher booking rates. Consider creating special weekend packages or promotions to increase weekday occupancy.</p>
                            <div class="recommendation-metrics">
                                <div class="metric">
                                    <span class="metric-value">72%</span>
                                    <span class="metric-label">Weekend Occupancy</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-value">48%</span>
                                    <span class="metric-label">Weekday Occupancy</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       
    document.addEventListener("DOMContentLoaded", function() {
        const revenueLabels = <?php echo json_encode($labels); ?>;
        const revenueData   = <?php echo json_encode($data); ?>;

        new Chart(document.getElementById('revenueChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue (<?php echo get_woocommerce_currency_symbol(); ?>)',
                    borderColor: '#2271b1',
                    backgroundColor: 'rgba(34,113,177,0.1)',
                    data: revenueData,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#2271b1',
                    pointRadius: 4
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { 
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    } 
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { drawBorder: false }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
   


                // Bookings by Status
                new Chart(document.getElementById('statusChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ["Confirmed", "Pending", "Cancelled", "Abandoned"],
                        datasets: [{
                            label: 'Bookings',
                            backgroundColor: ['#46b450','#ffb900','#dc3232','#50575e'],
                            data: [
                                <?php echo (int)$confirmed; ?>,
                                <?php echo (int)$pending; ?>,
                                <?php echo (int)$cancelled; ?>,
                                <?php echo (int)$abandoned; ?>
                            ],
                            borderRadius: 4,
                            borderSkipped: false
                        }]
                    },
                    options: { 
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false } 
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { drawBorder: false }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            
            // Show/hide custom date range based on selection
            const rangeSelect = document.getElementById('range');
            const dateRangeGroups = document.querySelectorAll('.date-range-group');
            
            function toggleDateRangeVisibility() {
                if (rangeSelect.value === 'custom') {
                    dateRangeGroups.forEach(group => {
                        group.style.display = 'flex';
                    });
                } else {
                    dateRangeGroups.forEach(group => {
                        group.style.display = 'none';
                    });
                }
            }
            
            rangeSelect.addEventListener('change', toggleDateRangeVisibility);
            toggleDateRangeVisibility(); // Initial call
        });
    </script>
</body>
</html>