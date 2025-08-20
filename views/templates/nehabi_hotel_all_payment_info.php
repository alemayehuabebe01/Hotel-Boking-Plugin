<?php

wp_enqueue_style('datatables');
wp_enqueue_script('datatables');

global $wpdb;
$table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

// Fetch all completed payments
$payments = $wpdb->get_results( "SELECT * FROM $table_name WHERE status = 'completed' ORDER BY id DESC" );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Booking Payments</h1>
    <hr class="wp-header-end">

    <?php if ( ! $payments ) : ?>
        <div class="notice notice-info">
            <p>No completed payments found.</p>
        </div>
    <?php else : ?>
        <table id="completed-payments-table" class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $payments as $payment ) : ?>
                    <tr>
                        <td><?php echo esc_html( $payment->booking_id ); ?></td>
                        <td><?php echo esc_html( $payment->order_id ); ?></td>
                        <td>
                            <strong><?php echo esc_html( $payment->customer_name ); ?></strong><br>
                            <small class="text-muted"><?php echo esc_html( $payment->customer_email ); ?></small>
                        </td>
                        <td><strong><?php echo esc_html( get_woocommerce_currency_symbol() . number_format( $payment->payment_total, 2 ) ); ?></strong></td>
                        <td><?php echo esc_html( $payment->payment_method ); ?></td>
                        <td>
                            <span class="payment-status <?php echo esc_attr( sanitize_title( $payment->status ) ); ?>">
                                <?php echo esc_html( ucfirst( $payment->status ) ); ?>
                            </span>
                        </td>
                        <td><?php echo esc_html( date( 'M j, Y \a\t g:i a', strtotime( $payment->created_at ) ) ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
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

#completed-payments-table thead th {
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

.payment-status {
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    min-width: 90px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.payment-status.completed { 
    background: #d4edda; 
    color: #155724;
    border: 1px solid #c3e6cb;
}

.text-muted {
    color: #6c757d !important;
}

/* DataTables Controls Styling */
.dataTables_wrapper {
    margin-top: 20px;
}

.dataTables_length,
.dataTables_filter,
.dataTables_info,
.dataTables_paginate {
    margin: 15px 0;
    font-size: 13px;
}

.dataTables_filter input {
    margin-left: 10px;
    border: 1px solid #8c8f94;
    padding: 6px 12px;
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.07);
    transition: all 0.2s ease;
}

.dataTables_filter input:focus {
    border-color: #2271b1;
    box-shadow: 0 0 0 1px #2271b1;
    outline: 2px solid transparent;
}

.dataTables_length select {
    margin: 0 10px;
    border: 1px solid #8c8f94;
    padding: 4px 8px;
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.07);
}

.dataTables_paginate .paginate_button {
    padding: 4px 8px;
    margin: 0 2px;
    border: 1px solid #dcdcde;
    border-radius: 3px;
    background: #f6f7f7;
    color: #2271b1;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.dataTables_paginate .paginate_button:hover {
    background: #2271b1;
    color: #fff;
    border-color: #2271b1;
}

.dataTables_paginate .paginate_button.current {
    background: #2271b1;
    color: #fff;
    border-color: #2271b1;
    font-weight: 600;
}

/* Responsive adjustments */
@media screen and (max-width: 1200px) {
    #completed-payments-table {
        font-size: 13px;
    }
    
    #completed-payments-table thead th,
    #completed-payments-table tbody td {
        padding: 8px;
    }
}

/* Loading overlay */
.dataTables_wrapper .dataTables_processing {
    background: rgba(255,255,255,0.9);
    border: 1px solid #dcdcde;
    border-radius: 4px;
    padding: 20px;
    font-weight: 600;
    color: #2c3338;
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#completed-payments-table').DataTable({
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "order": [[6, "desc"]], // Sort by Date column (7th column) descending
        "responsive": true,
        "dom": '<"top"<"dataTables-header"lf>>rt<"bottom"<"dataTables-footer"ip>><"clear">',
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
        },
        "initComplete": function() {
            // Add some custom classes after initialization
            $('.dataTables_length').addClass('dataTables-controls');
            $('.dataTables_filter').addClass('dataTables-controls');
        }
    });
});
</script>