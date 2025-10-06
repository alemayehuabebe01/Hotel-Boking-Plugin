<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WooCommerce Orders Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
    <style>

        * {
            box-sizing: border-box; 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        body {
            background-color: #f1f1f1;
            color: #333;
            line-height: 1.6;
           
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e5e5;
        }
        
        h1 {
            font-size: 23px;
            font-weight: 400;
            color: #333;
        }
        
        .header-actions {
            display: flex;
            gap: 10px;
        }
        
        .filter-section {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }
        
        .filter-group label {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 13px;
        }
        
        select, input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background: #fff;
        }
        
        button {
            padding: 8px 16px;
            background: #2271b1;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        button:hover {
            background: #135e96;
        }
        
        button.export-btn {
            background: #46b450;
        }
        
        button.export-btn:hover {
            background: #3a9e43;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 12px 15px;
            background: #f8f9fa;
            font-weight: 500;
            border-bottom: 1px solid #e5e5e5;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e5e5;
            vertical-align: top;
        }
        
        tr:hover {
            background-color: #f5f9ff;
        }
        
        .order-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-completed {
            background: #d1f4da;
            color: #1a7544;
        }
        
        .status-processing {
            background: #c6e5ff;
            color: #0063ad;
        }
        
        .status-pending {
            background: #ffe6bf;
            color: #955a00;
        }
        
        .status-on-hold {
            background: #f9d7dc;
            color: #c2404d;
        }
        
        .status-cancelled {
            background: #e5e5e5;
            color: #737373;
        }
        
        .status-refunded {
            background: #e5e7eb;
            color: #374151;
        }
        
        .customer-info {
            display: flex;
            flex-direction: column;
        }
        
        .customer-name {
            font-weight: 500;
        }
        
        .customer-email {
            font-size: 12px;
            color: #666;
        }
        
        .order-total {
            font-weight: 500;
        }
        
        .order-date {
            white-space: nowrap;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .action-btn {
            padding: 5px;
            background: transparent;
            color: #555;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .action-btn:hover {
            color: #2271b1;
            background: transparent;
        }
        
        .dataTables_wrapper {
            margin-top: 20px;
        }
        
        .dataTables_info {
            padding-top: 15px !important;
        }
        
        .dataTables_filter {
            margin-bottom: 15px;
        }
        
        .bulk-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }
        
        .select-all {
            margin-right: 10px;
        }
        
        @media (max-width: 768px) {
            .filter-section {
                flex-direction: column;
            }
            
            .filter-group {
                width: 100%;
            }
            
            .header-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-shopping-cart"></i> All Bookings</h1>
            <div class="header-actions">
                <button><i class="fas fa-plus"></i> Add Order</button>
                <button class="export-btn"><i class="fas fa-file-export"></i> Export</button>
                <button><i class="fas fa-cog"></i> Settings</button>
            </div>
        </header>
       
        
        <div class="filter-section">
            <div class="filter-group">
                <label for="status-filter">Filter by Status</label>
                <select id="status-filter">
                    <option value="">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="processing">Processing</option>
                    <option value="pending">Pending</option>
                    <option value="on-hold">On Hold</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="date-from">Date From</label>
                <input type="date" id="date-from">
            </div>
            
            <div class="filter-group">
                <label for="date-to">Date To</label>
                <input type="date" id="date-to">
            </div>
            
            <div class="filter-group">
                <label for="customer-filter">Customer</label>
                <select id="customer-filter">
                    <option value="">All Customers</option>
                    <option value="1">John Doe</option>
                    <option value="2">Jane Smith</option>
                    <option value="3">Robert Johnson</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="search-input">Search</label>
                <input type="text" id="search-input" placeholder="Search orders...">
            </div>
        </div>
        
        <div class="bulk-actions">
            <select id="bulk-action">
                <option value="">Bulk Actions</option>
                <option value="edit">Edit</option>
                <option value="trash">Move to Trash</option>
                <option value="export">Export Selected</option>
            </select>
            <button id="apply-bulk-action">Apply</button>
            <span class="select-all">
                <input type="checkbox" id="select-all">
                <label for="select-all">Select All</label>
            </span>
        </div>
        
        <table id="orders-table" class="display">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
           <tbody>
    <?php
    $args = [
        'post_type'      => 'shop_order',
        'post_status'    => array_keys( wc_get_order_statuses() ),
        'posts_per_page' => 20, // adjust as needed
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $orders = get_posts( $args );

    if ( $orders ) {
        foreach ( $orders as $order_post ) {
            $order = wc_get_order( $order_post->ID );

            $order_id     = $order->get_id();
            $order_date   = $order->get_date_created() ? $order->get_date_created()->date('Y-m-d') : '';
            $order_total  = $order->get_formatted_order_total();
            $status       = $order->get_status();
            $customer     = $order->get_formatted_billing_full_name();
            $customer_email = $order->get_billing_email();
            ?>
            <tr>
                <td>#<?php echo esc_html( $order_id ); ?></td>
                <td class="order-date"><?php echo esc_html( $order_date ); ?></td>
                <td>
                    <div class="customer-info">
                        <span class="customer-name"><?php echo esc_html( $customer ); ?></span>
                        <span class="customer-email"><?php echo esc_html( $customer_email ); ?></span>
                    </div>
                </td>
                <td>
                    <select class="order-status-select">
                        <?php foreach ( wc_get_order_statuses() as $key => $label ) : ?>
                            <option value="<?php echo esc_attr( str_replace('wc-', '', $key) ); ?>" <?php selected( 'wc-' . $status, $key ); ?>>
                                <?php echo esc_html( $label ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="order-total"><?php echo wp_kses_post( $order_total ); ?></td>
                <td class="action-buttons">
                    <a href="<?php echo esc_url( admin_url( 'post.php?post=' . $order_id . '&action=edit' ) ); ?>" class="action-btn" title="View"><i class="fas fa-eye"></i></a>
                    <a href="<?php echo esc_url( admin_url( 'post.php?post=' . $order_id . '&action=edit' ) ); ?>" class="action-btn" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="<?php echo get_delete_post_link( $order_id ); ?>" class="action-btn" title="Delete"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php
        }
    } else {
        echo '<tr><td colspan="6">No orders found.</td></tr>';
    }
    ?>
</tbody>
        </table>

         <?PHP
        
$args = array(
    'post_type'      => 'shop_order', // Specify the custom post type for WooCommerce orders
    'post_status'    => array_keys( wc_get_order_statuses() ), // Get all possible order statuses
    'posts_per_page' => -1, // Retrieve all orders (no pagination)
);

$orders_query = new WP_Query( $args );

if ( $orders_query->have_posts() ) :
    while ( $orders_query->have_posts() ) : $orders_query->the_post();
        $order_id = get_the_ID();
        $order = wc_get_order( $order_id );

        // Now you can access order data using the $order object
        // For example:
         echo 'Order ID: ' . $order->get_id() . '<br>';
        // echo 'Order Status: ' . $order->get_status() . '<br>';
        // echo 'Order Total: ' . $order->get_total() . '<br>';
    endwhile;
    wp_reset_postdata(); // Reset post data after the loop
else :
    echo 'No orders found.';
endif;
?>
         

      
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#orders-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'export-btn'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'export-btn'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'export-btn'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'export-btn'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'export-btn'
                    }
                ],
                pageLength: 10,
                responsive: true,
                select: true,
                order: [[1, 'desc']] // Sort by date descending by default
            });
            
            // Filter by status
            $('#status-filter').on('change', function() {
                table.column(3).search(this.value).draw();
            });
            
            // Search input
            $('#search-input').on('keyup', function() {
                table.search(this.value).draw();
            });
            
            // Select all functionality
            $('#select-all').on('click', function() {
                var rows = table.rows({ 'search': 'applied' });
                if (this.checked) {
                    rows.select();
                } else {
                    rows.deselect();
                }
            });
            
            // Update status style when changed
            $('.order-status-select').on('change', function() {
                // In a real application, you would send an AJAX request to update the order status
                alert('Order status updated to: ' + $(this).val());
            });
            
            // Apply bulk action
            $('#apply-bulk-action').on('click', function() {
                var action = $('#bulk-action').val();
                if (!action) {
                    alert('Please select a bulk action');
                    return;
                }
                
                var selectedRows = table.rows({ selected: true });
                if (selectedRows.count() === 0) {
                    alert('Please select at least one order');
                    return;
                }
                
                alert('Applying "' + action + '" to ' + selectedRows.count() + ' orders');
                // In a real application, you would process the bulk action here
            });
        });
    </script>
</body>
</html>