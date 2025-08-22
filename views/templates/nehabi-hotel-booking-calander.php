<?php
global $wpdb;
$table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

// Get accommodation IDs that have bookings
$accommodation_ids = $wpdb->get_col("SELECT DISTINCT accommodation_id FROM $table_name ORDER BY accommodation_id ASC");

// Define date range (2 weeks from today or GET param)
$start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : date('Y-m-d');
$end_date   = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : date('Y-m-d', strtotime('+14 days', strtotime($start_date)));

// Generate date range
$dates = [];
$current = strtotime($start_date);
while ($current <= strtotime($end_date)) {
    $dates[] = date('Y-m-d', $current);
    $current = strtotime('+1 day', $current);
}

// Fetch bookings in this range
$bookings = $wpdb->get_results($wpdb->prepare("
    SELECT accommodation_id, DATE(check_in) as check_in, DATE(check_out) as check_out, status
    FROM $table_name
    WHERE (DATE(check_in) <= %s AND DATE(check_out) >= %s)
", $end_date, $start_date));

// Index bookings by accommodation + date
$calendar_data = [];
foreach ($bookings as $booking) {
    $period = new DatePeriod(
        new DateTime($booking->check_in),
        new DateInterval('P1D'),
        (new DateTime($booking->check_out))->modify('+1 day')
    );
    foreach ($period as $day) {
        $calendar_data[$booking->accommodation_id][$day->format('Y-m-d')] = $booking->status;
    }
}
?>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
       
        
        .booking-container {
            max-width: 1400px;
            background: white;
            margin-top : 15px;
        }
        
        .header {
            color: black;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-weight: 600;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header h1 i {
            font-size: 28px;
        }
        
        .controls {
            background: #f8f9fa;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eaecef;
        }
        
        .view-options {
            display: flex;
            gap: 10px;
        }
        
        .view-options button {
            padding: 8px 16px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .view-options button.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .view-options button:hover {
            background: #e8f4ff;
        }
        
        .date-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .date-filter input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .date-filter button {
            padding: 8px 16px;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
        }
        
        .date-filter button:hover {
            background: #3498db;
        }
        
        .calendar-wrapper {
            overflow-x: auto;
            padding: 0 10px;
        }
        
        .booking-calendar {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            font-size: 13px;
            margin: 15px 0;
            min-width: 1000px;
        }
        
        .booking-calendar th, .booking-calendar td {
            border: 1px solid #eaecef;
            padding: 8px 4px;
            text-align: center;
            vertical-align: middle;
        }
        
        .booking-calendar thead th {
            background: #f8f9fa;
            font-weight: 600;
            padding: 12px 4px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .booking-calendar .fixed-col {
            width: 220px;
            min-width: 220px;
            position: sticky;
            left: 0;
            background: white;
            z-index: 5;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            padding: 10px;
        }
        
        .booking-calendar .room-name {
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .room-thumbnail {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
            border: 2px solid #eaecef;
        }
        
        .date-header {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .date-day {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .date-month {
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
        }
        
        .date-weekday {
            font-size: 12px;
            color: #3498db;
            font-weight: 500;
        }
        
        .status-cell {
            height: 50px;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
        }
        
        .status-cell:hover {
            background-color: #f1f8ff;
        }
        
        .status-indicator {
            display: inline-block;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            line-height: 32px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }
        
        .status-cell:hover .status-indicator {
            transform: scale(1.2);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .status-details {
            display: none;
            position: absolute;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 12px;
            z-index: 20;
            width: 200px;
            text-align: left;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 5px;
        }
        
        .status-cell:hover .status-details {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, 10px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
        
        .status-booked .status-indicator { 
            background: #27ae60;
            box-shadow: 0 2px 5px rgba(39, 174, 96, 0.3);
        }
        
        .status-pending .status-indicator { 
            background: #f39c12;
            box-shadow: 0 2px 5px rgba(243, 156, 18, 0.3);
        }
        
        .status-external .status-indicator { 
            background: #3498db;
            box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
        }
        
        .status-blocked .status-indicator { 
            background: #e74c3c;
            box-shadow: 0 2px 5px rgba(231, 76, 60, 0.3);
        }
        
        .empty-cell {
            background: #f9f9f9;
        }
        
        .legend {
            padding: 20px;
            border-top: 1px solid #eaecef;
            display: flex;
            justify-content: center;
        }
        
        .legend-items {
            display: flex;
            gap: 25px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }
        
        .legend-booked { background: #27ae60; }
        .legend-pending { background: #f39c12; }
        .legend-external { background: #3498db; }
        .legend-blocked { background: #e74c3c; }
        
        .today .date-day {
            color: #e74c3c;
        }
        
        .today .date-month, .today .date-weekday {
            color: #e74c3c;
        }
        
        @media (max-width: 1200px) {
            .controls {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .date-filter {
                width: 100%;
                justify-content: flex-end;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .view-options {
                width: 100%;
                justify-content: center;
            }
            
            .date-filter {
                flex-wrap: wrap;
            }
            
            .booking-calendar .fixed-col {
                width: 180px;
                min-width: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="">
        <div class="header">
            <h1><i class="fas fa-calendar-alt"></i>Booking Calendar</h1>
            <div class="header-info">
                <p>Last updated: <?php echo date('M j, Y \a\t g:i A'); ?></p>
            </div>
        </div>
        
        <div class="controls">
            <div class="view-options">
                <button class="active">Day</button>
                <button>Week</button>
                <button>Month</button>
            </div>
            
            <form method="get" action="" class="date-filter">
                <input type="hidden" name="page" value="<?php echo esc_attr($_GET['page']); ?>">
                <input type="date" id="start_date" name="start_date" value="<?php echo esc_attr($start_date); ?>">
                <span>to</span>
                <input type="date" id="end_date" name="end_date" value="<?php echo esc_attr($end_date); ?>">
                <button type="submit">Apply</button>
                <!-- <a href="?page=<?php echo esc_attr($_GET['page']); ?>" class="button" style="padding:8px 16px;background:#95a5a6;color:white;border:none;border-radius:6px;cursor:pointer;text-decoration:none;">Reset</a> -->
            </form>
        </div>
        
        <div class="calendar-wrapper">
            <table class="booking-calendar">
                <thead>
                    <tr>
                        <th class="fixed-col">Accommodation</th>
                        <?php foreach ($dates as $d): ?>
                            <th class="<?php echo ($d === date('Y-m-d')) ? 'today' : ''; ?>">
                                <div class="date-header">
                                    <div class="date-day"><?php echo date('j', strtotime($d)); ?></div>
                                    <div class="date-month"><?php echo date('M', strtotime($d)); ?></div>
                                    <div class="date-weekday"><?php echo date('D', strtotime($d)); ?></div>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accommodation_ids as $acc_id): 
                        $post = get_post($acc_id); // Get accommodation CPT
                        if (!$post) continue;

                        $title = get_the_title($post);
                        $permalink = get_permalink($post);
                        $thumbnail = get_the_post_thumbnail_url($post, 'thumbnail');
                        ?>
                        <tr>
                            <td class="fixed-col">
                                <div class="room-name">
                                    <?php if ($thumbnail): ?>
                                        <img src="<?php echo esc_url($thumbnail); ?>" class="room-thumbnail">
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url($permalink); ?>" target="_blank">
                                        <?php echo esc_html($title); ?>
                                    </a>
                                </div>
                            </td>
                            <?php foreach ($dates as $d): 
                                $status = $calendar_data[$acc_id][$d] ?? '';
                                ?>
                                <td class="status-cell <?php echo $status ? 'status-' . esc_attr(strtolower($status)) : 'empty-cell'; ?>">
                                    <?php if ($status): ?>
                                        <div class="status-indicator">
                                            <?php echo strtoupper(substr($status, 0, 1)); ?>
                                        </div>
                                        <div class="status-details">
                                            <strong><?php echo ucfirst($status); ?></strong><br>
                                            Accommodation: <?php echo esc_html($title); ?><br>
                                            Date: <?php echo date('M j, Y', strtotime($d)); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="legend">
            <div class="legend-items">
                <div class="legend-item">
                    <span class="legend-color legend-booked"></span>
                    <span>Booked</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color legend-pending"></span>
                    <span>Pending</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color legend-external"></span>
                    <span>External</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color legend-blocked"></span>
                    <span>Blocked</span>
                </div>
                <div class="legend-item">
                    <span style="display:inline-block; width:20px; height:20px; border-radius:50%; background:#f9f9f9; border:1px solid #eaefecff;"></span>
                    <span>Available</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript for view toggle buttons
        document.querySelectorAll('.view-options button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.view-options button').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
        
        // Highlight today's date
        const today = new Date();
        const todayFormatted = today.toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(input => {
            if (!input.value) {
                input.value = todayFormatted;
            }
        });
    </script>
</body>
</html>