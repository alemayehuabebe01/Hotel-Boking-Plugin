<?php

wp_enqueue_style('datatables');
wp_enqueue_script('datatables');

global $wpdb;
$table_name = $wpdb->prefix . 'wishu_nehabi_hotel_payments';

// Fetch all completed payments
$payments = $wpdb->get_results( "SELECT * FROM $table_name WHERE status = 'completed' ORDER BY id DESC" );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Completed Payments</h1>

    <?php if ( ! $payments ) : ?>
        <p>No completed payments found.</p>
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
                            <?php echo esc_html( $payment->customer_name ); ?><br>
                            <small><?php echo esc_html( $payment->customer_email ); ?></small>
                        </td>
                        <td><?php echo esc_html( get_woocommerce_currency_symbol() . number_format( $payment->payment_total, 2 ) ); ?></td>
                        <td><?php echo esc_html( $payment->payment_method ); ?></td>
                        <td>
                            <span class="payment-status <?php echo esc_attr( sanitize_title( $payment->status ) ); ?>">
                                <?php echo esc_html( ucfirst( $payment->status ) ); ?>
                            </span>
                        </td>
                        <td><?php echo esc_html( date( 'Y-m-d H:i', strtotime( $payment->created_at ) ) ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
#completed-payments-table {
    width: 100% !important;
}

.payment-status {
    padding: 4px 8px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    min-width: 80px;
    text-align: center;
}

.payment-status.completed { 
    background: #d4edda; 
    color: #155724; 
}

.dataTables_filter input {
    margin-left: 10px;
    border: 1px solid #ddd;
    padding: 4px 8px;
    border-radius: 4px;
}

.dataTables_length select {
    margin: 0 10px;
    border: 1px solid #ddd;
    padding: 4px 8px;
    border-radius: 4px;
}
</style>

<script>
jQuery(document).ready(function($) {
    $('#completed-payments-table').DataTable({
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "order": [[6, "desc"]], // Sort by Date column (7th column) descending
        "responsive": true,
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});
</script>