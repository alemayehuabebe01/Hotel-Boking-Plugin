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

// Fetch all completed payments
$payments = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Booking Payments</h1>
    <a href="#" class="page-title-action" id="refresh-payments">
        <span class="dashicons dashicons-update"></span> Refresh
    </a>
    <hr class="wp-header-end">

    <?php if ( ! $payments ) : ?>
        <div class="notice notice-info">
            <p>No completed payments found.</p>
        </div>
    <?php else : ?>
        <div class="tablenav top">
            <div class="alignleft actions">
            </div>
            <div class="tablenav-pages">
                <span class="displaying-num"><?php echo count($payments); ?> items</span>
            </div>
        </div>

        <table id="completed-payments-table" class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th scope="col" class="column-primary">Booking ID</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer</th>
                    <th scope="col" class="num">Amount</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $payments as $payment ) : ?>
                    <tr>
                        <td class="column-primary" data-colname="Booking ID">
                            <strong><?php echo esc_html( $payment->booking_id ); ?></strong>
                            <button type="button" class="toggle-row">
                                <span class="screen-reader-text">Show more details</span>
                            </button>
                        </td>
                        <td data-colname="Order ID"><?php echo esc_html( $payment->order_id ); ?></td>
                        <td data-colname="Customer">
                            <strong><?php echo esc_html( $payment->customer_name ); ?></strong><br>
                            <small><?php echo esc_html( $payment->customer_email ); ?></small>
                        </td>
                        <td data-colname="Amount" class="num">
                            <strong><?php echo esc_html( get_woocommerce_currency_symbol() . number_format( $payment->payment_total, 2 ) ); ?></strong>
                        </td>
                        <td data-colname="Payment Method"><?php echo esc_html( $payment->payment_method ); ?></td>
                        <td data-colname="Status">
                            <span class="payment-status <?php echo esc_attr( sanitize_title( $payment->status ) ); ?>">
                                <?php echo esc_html( ucfirst( $payment->status ) ); ?>
                            </span>
                        </td>
                        <td data-colname="Date"><?php echo esc_html( date( 'M j, Y \a\t g:i a', strtotime( $payment->created_at ) ) ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col" class="column-primary">Booking ID</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer</th>
                    <th scope="col" class="num">Amount</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
</div>

<style>
#completed-payments-table {
    width: 100% !important;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 15px;
}

#completed-payments-table thead th,
#completed-payments-table tfoot th {
    background: #f6f7f7;
    border-bottom: 2px solid #ccd0d4;
    font-weight: 600;
    padding: 12px;
    color: #2c3338;
}

#completed-payments-table tbody td {
    padding: 12px;
    vertical-align: middle;
    border-bottom: 1px solid #ccd0d4;
}

#completed-payments-table tbody tr:hover {
    background-color: #f6f7f7;
}

#completed-payments-table th.num,
#completed-payments-table td.num {
    text-align: right;
}

.payment-status {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
    min-width: 80px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.payment-status.completed { 
    background: #d4edda; 
    color: #155724;
    border: 1px solid #c3e6cb;
}

.payment-status.pending { 
    background: #fff3cd; 
    color: #856404;
    border: 1px solid #ffeeba;
}

.payment-status.failed { 
    background: #f8d7da; 
    color: #721c24;
    border: 1px solid #f5c6cb;
}

small {
    color: #646970 !important;
}

/* DataTables Controls Styling */
.dataTables_wrapper {
    margin-top: 15px;
}

.dataTables_length,
.dataTables_filter {
    margin-bottom: 15px;
}

.dataTables_filter input {
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

#refresh-payments .dashicons {
    font-size: 16px;
    vertical-align: middle;
    margin-top: -2px;
}

/* Responsive styles */
@media screen and (max-width: 782px) {
    #completed-payments-table th.column-primary,
    #completed-payments-table td.column-primary {
        position: relative;
        padding-right: 40px;
    }
    
    #completed-payments-table .toggle-row {
        position: absolute;
        right: 10px;
        top: 10px;
    }
    
    #completed-payments-table td:before {
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
    // Initialize DataTable
    var table = $('#completed-payments-table').DataTable({
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "order": [[6, "desc"]], // Sort by Date column
        "responsive": true,
        "dom": '<"top"<"dataTables-header"lfB>>rt<"bottom"<"dataTables-footer"ip>><"clear">',
        "buttons": [
            {
                extend: 'excelHtml5',
                title: 'Booking Payments',
                className: 'button',
                text: '<span class="dashicons dashicons-media-spreadsheet"></span> Export to Excel',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'print',
                title: 'Booking Payments',
                className: 'button',
                text: '<span class="dashicons dashicons-printer"></span> Print',
                exportOptions: { columns: ':visible' }
            }
        ],
        "language": {
            "search": "Search payments:",
            "lengthMenu": "Show _MENU_ entries per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ payments",
            "infoEmpty": "Showing 0 to 0 of 0 payments",
            "infoFiltered": "(filtered from _MAX_ total payments)",
            "paginate": {
                "first": "« First",
                "last": "Last »",
                "next": "Next →",
                "previous": "← Previous"
            },
            "processing": "Processing payments..."
        }
    });
    
    // Add icons to buttons after they're created
    setTimeout(function() {
        $('.dt-button:first').prepend('<span class="dashicons dashicons-media-spreadsheet" style="vertical-align: middle; margin-right: 4px;"></span>');
        $('.dt-button:last').prepend('<span class="dashicons dashicons-printer" style="vertical-align: middle; margin-right: 4px;"></span>');
    }, 100);
    
    // Refresh button functionality
    $('#refresh-payments').on('click', function(e) {
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