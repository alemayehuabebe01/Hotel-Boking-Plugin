jQuery(document).ready(function ($) {
    // Initialize color picker
    $('.nehabi-color-picker').wpColorPicker();

    // Template preview functionality
    $('.template-preview').on('click', function (e) {
        e.preventDefault();
        var templateType = $(this).data('template');
        var data = {
            'action': 'nehabi_preview_email',
            'template_type': templateType,
            'email_options': $('#nehabi-email-options-form').serialize()
        };

        // AJAX request to generate preview
        $.post(ajaxurl, data, function (response) {
            $('#nehabi-email-preview').html(response);
            $('#nehabi-preview-modal').show();
        });
    });

    // Close preview modal
    $('.close-preview').on('click', function () {
        $('#nehabi-preview-modal').hide();
    });
});