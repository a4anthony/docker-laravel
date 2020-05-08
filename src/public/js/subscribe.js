$(document).ready(function() {
    $("#close-alert").on('click', function(e) {
        $('#alert-msg').empty();
        $('#alert-divv').removeClass('alert-error');
        $('#alert-divv').addClass('d-none');
    });


    $(".subscribe-btn").on('click', function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        setTimeout(function() {

            $.ajax({
                url: "/subscribe",
                method: 'POST',
                data: $('#subscribe-form').serialize(),
                success: function(response) {
                    $('#email').val('');

                    clearTimeout(); //cancel the previous timer.
                    $('#alert-msg').empty();
                    $('#alert-msg').append("Successful subscription");
                    $('.alert-divv').slideDown().delay(1000).fadeIn(500);
                    $('#alert-divv').removeClass('alert-error');
                    $('#alert-divv').removeClass('d-none');
                    setTimeout(function() {
                        $('#alert-divv').slideUp().delay(1000).fadeOut(500);
                    }, 10000);
                },
                error: function(jqXhr) {
                    var responseMsg = jqXhr.responseJSON;
                    var errorMsg = 'There was a general problem with your request';

                    clearTimeout(); //cancel the previous timer.
                    $('#alert-msg').empty();
                    $('#alert-msg').append(responseMsg.errors.email);
                    $('.alert-divv').slideDown().delay(1000).fadeIn(500);
                    $('#alert-divv').addClass('alert-error');
                    $('#alert-divv').removeClass('d-none');
                    setTimeout(function() {
                        $('#alert-msg').empty();
                        $('#alert-divv').removeClass('alert-error');
                        $('#alert-divv').addClass('d-none');
                    }, 10000);

                }
            });
        }, 2000);
    });
});