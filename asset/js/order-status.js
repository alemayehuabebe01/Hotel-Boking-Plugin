jQuery(document).ready(function ($) {
    $('.order-status-select').on('change', function () {
        var orderId = $(this).data('order-id');
        var newStatus = $(this).val(); // e.g., "wc-completed"

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'change_order_status',
                order_id: orderId,
                new_status: newStatus,
                _ajax_nonce: myOrderStatus.nonce
            },
            success: function (response) {
                alert('Order status updated!');
            },
            error: function () {
                alert('Error updating order status.');
            }
        });
    });
});
