jQuery(function ($) {
    $(document).on('change', '.hb-order-status-select', function () {
        var orderId = $(this).data('order-id');
        var newStatus = $(this).val();
        var nonce = $(this).data('nonce');

        $.ajax({
            url: myOrderStatus.ajax,
            method: 'POST',
            data: {
                action: 'change_order_status',
                order_id: orderId,
                new_status: newStatus,
                _ajax_nonce: nonce
            },
            success: function (resp) {
                toastr.success('Order status updated successfully');
            },
            error: function () {
                toastr.error('Error updating order status');
            }
        });
    });
});