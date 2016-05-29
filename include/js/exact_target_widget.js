// Resolving conflict with $

jQuery(document).ready(function ($) {


    $("#et_form").submit(function(e){
        e.preventDefault();
        //alert('click');

        var dataEl = $("#et_email").val();

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: "xml",
            data: {
                'action':'exact-target-ajax-submit',
                'exwemail':dataEl
            },
            success:function (response) {
                var r_status = $(response).find('response_data').text();
                var r_message = $(response).find('supplemental message').text();

                if(r_status === 'success'){
                    $("#et_email").val(r_message);
                }else{
                    $("#et_email").val(r_message);
                }
            },
            error:function (response) {
                var r_status = $(response).find('response_data').text();
                var r_message = $(response).find('supplemental message').text();

                if(r_status === 'error'){
                    $("#et_email").val(r_message);
                }
            }
        });

    });
});



