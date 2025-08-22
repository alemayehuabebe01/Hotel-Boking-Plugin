<?php
// Enqueue DataTables core
wp_enqueue_style('datatables');
wp_enqueue_script('datatables');

// Enqueue DataTables Buttons extension (Excel + Print)
wp_enqueue_style('datatables-buttons', 'https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css');
wp_enqueue_script('datatables-buttons', 'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js', ['jquery', 'datatables'], null, true);
wp_enqueue_script('datatables-jszip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js', [], null, true);
wp_enqueue_script('datatables-buttons-html5', 'https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js', ['datatables-buttons'], null, true);
wp_enqueue_script('datatables-buttons-print', 'https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js', ['datatables-buttons'], null, true);

global $wpdb;
$table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

// Fetch unique customers from payments
$customers = $wpdb->get_results("
    SELECT 
        customer_name,
        customer_email,
        COUNT(booking_id) as total_bookings,
        SUM(payment_total) as total_spent,
        MAX(created_at) as last_booking_date
    FROM $table_name
    GROUP BY customer_email
    ORDER BY last_booking_date DESC
");
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Customers</h1>
    <a href="#" class="page-title-action" id="refresh-customers">
        <span class="dashicons dashicons-update"></span> Refresh
    </a>
    <hr class="wp-header-end">

    <?php if ( ! $customers ) : ?>
        <div class="notice notice-info">
            <p>No customers found.</p>
        </div>
    <?php else : ?>
        <div class="wp-list-table-wrapper">
            <table id="customers-table" class="wp-list-table widefat fixed striped table-view-list">
                <thead>
                    <tr>
                        <th scope="col" class="column-primary">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="num">Total Bookings</th>
                        <th scope="col" class="num">Total Spent</th>
                        <th scope="col">Last Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $customers as $customer ) : ?>
                        <tr>
                            <td class="column-primary">
                                <strong><?php echo esc_html( $customer->customer_name ); ?></strong>
                                <button type="button" class="toggle-row">
                                    <span class="screen-reader-text">Show more details</span>
                                </button>
                            </td>
                            <td data-colname="Email"><?php echo esc_html( $customer->customer_email ); ?></td>
                            <td data-colname="Total Bookings" class="num"><?php echo esc_html( $customer->total_bookings ); ?></td>
                            <td data-colname="Total Spent" class="num"><strong><?php echo esc_html( get_woocommerce_currency_symbol() . number_format( $customer->total_spent, 2 ) ); ?></strong></td>
                            <td data-colname="Last Booking Date"><?php echo esc_html( date( 'M j, Y \a\t g:i a', strtotime( $customer->last_booking_date ) ) ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col" class="column-primary">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="num">Total Bookings</th>
                        <th scope="col" class="num">Total Spent</th>
                        <th scope="col">Last Booking Date</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
#customers-table {
    width: 100% !important;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 15px;
}

#customers-table thead th,
#customers-table tfoot th {
    background: #f6f7f7;
    border-bottom: 2px solid #ccd0d4;
    font-weight: 600;
    padding: 12px;
    color: #2c3338;
}

#customers-table tbody td {
    padding: 12px;
    vertical-align: middle;
    border-bottom: 1px solid #ccd0d4;
}

#customers-table tbody tr:hover {
    background-color: #f6f7f7;
}

#customers-table th.num,
#customers-table td.num {
    text-align: right;
}

.wp-list-table-wrapper {
    position: relative;
}

.dataTables_wrapper {
    margin-top: 15px;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 15px;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 10px;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #8c8f94;
}

.dataTables_wrapper .dataTables_info {
    color: #50575e;
    padding: 10px 0;
}

.dataTables_wrapper .dataTables_paginate {
    padding: 10px 0;
}

.dataTables_wrapper .paginate_button {
    padding: 4px 8px;
    border: 1px solid #ccc;
    margin-left: 2px;
    border-radius: 4px;
    background: #f7f7f7;
    color: #0073aa;
    cursor: pointer;
}

.dataTables_wrapper .paginate_button.current {
    background: #0073aa;
    color: white;
    border-color: #0073aa;
}

.dataTables_wrapper .paginate_button:hover {
    background: #00a0d2;
    color: white;
    border-color: #00a0d2;
}

.dt-buttons {
    margin-bottom: 15px;
}

.dt-button {
    background: #f7f7f7;
    border: 1px solid #ccc;
    color: #0073aa;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
    font-size: 14px;
    line-height: 1.5;
}

.dt-button:hover {
    background: #00a0d2;
    color: white;
    border-color: #00a0d2;
}

#refresh-customers .dashicons {
    font-size: 16px;
    vertical-align: middle;
    margin-top: -2px;
}

/* Responsive styles */
@media screen and (max-width: 782px) {
    #customers-table th.column-primary,
    #customers-table td.column-primary {
        position: relative;
        padding-right: 40px;
    }
    
    #customers-table .toggle-row {
        position: absolute;
        right: 10px;
        top: 10px;
    }
    
    #customers-table td:before {
        content: attr(data-colname);
        font-weight: 600;
        padding-right: 10px;
    }
    
    .dataTables_wrapper .dataTables_length select {
        padding: 6px 8px;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Initialize DataTable for customers
    var table = $('#customers-table').DataTable({
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "order": [[4, "desc"]], // Sort by last booking date
        "responsive": true,
        "dom": '<"top"<"dataTables-header"lfB>>rt<"bottom"<"dataTables-footer"ip>><"clear">',
        "buttons": [
            {
                extend: 'excelHtml5',
                title: 'Customer List',
                className: 'button',
                text: '<span class="dashicons dashicons-media-spreadsheet"></span> Export to Excel',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'print',
                title: 'Customer List',
                className: 'button',
                text: '<span class="dashicons dashicons-printer"></span> Print',
                exportOptions: { columns: ':visible' }
            }
        ],
        "language": {
            "search": "Search customers:",
            "lengthMenu": "Show _MENU_ entries per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ customers",
            "infoEmpty": "Showing 0 to 0 of 0 customers",
            "infoFiltered": "(filtered from _MAX_ total customers)",
            "paginate": {
                "first": "« First",
                "last": "Last »",
                "next": "Next →",
                "previous": "← Previous"
            },
            "processing": "Loading customers..."
        }
    });
    
    // Add icons to buttons after they're created
    setTimeout(function() {
        $('.dt-button:first').prepend('<span class="dashicons dashicons-media-spreadsheet" style="vertical-align: middle; margin-right: 4px;"></span>');
        $('.dt-button:last').prepend('<span class="dashicons dashicons-printer" style="vertical-align: middle; margin-right: 4px;"></span>');
    }, 100);
    
    // Refresh button functionality
    $('#refresh-customers').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        button.addClass('updating-message');
        
        // Simulate refresh (in a real scenario, you'd reload data from server)
        setTimeout(function() {
            table.ajax.reload(null, false);
            button.removeClass('updating-message');
        }, 800);
    });
});
</script>