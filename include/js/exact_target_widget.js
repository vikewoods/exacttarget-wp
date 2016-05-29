// Resolving conflict with $

jQuery(document).ready(function ($) {
    $("#et_form").submit(function (e) {
        e.preventDefault();

        var dataEl = $("#et_email").val();

        // $("#et_button").disable();
        // $("#et_email").disable();

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: "xml",
            data: {
                'action': 'exact-target-ajax-submit',
                'exwemail': dataEl
            },
            success: function (response) {
                var r_status = $(response).find('response_data').text();
                var r_message = $(response).find('supplemental message').text();

                if (r_status === 'success') {
                    $("#et_result").text(r_message).addClass('et_success');
                } else {
                    $("#et_result").text(r_message).addClass('et_error');
                }
            },
            error: function (response) {
                var r_status = $(response).find('response_data').text();
                var r_message = $(response).find('supplemental message').text();

                if (r_status === 'error') {
                    $("#et_result").text(r_message).addClass('et_error');
                }
            }
        });

    });
});



