$(document).ready(function() {

    //retrieve selected option if user edits address if stored in session
    var selected = sessionStorage.getItem('selected');
    if (selected) {
        $("#address_select").val(selected);
        //include csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //retrieves selected adddress details from database
        $.ajax({
            url: '/checkout/address/' + selected,
            method: 'GET',
            success: function(response) {
                var address_id = response[0]['address_id'];
                var address_address = response[0]['address_address'];
                var landmark = response[0]['landmark'];

                $('.display_address').removeClass('d-none');
                $("#address").empty();
                $("#landmark").empty();
                $("#edit_btn").empty();
                $("#state_country").empty();
                $("#address").append("<p>" + address_address + "</p>");
                if (landmark != null) {
                    $("#landmark").append("<p>Near " + landmark + "</p>");
                }
                $("#state_country").append("<p>Akwa Ibom State, Nigeria.</p>");
                $("#edit_btn").append("<a id='edit_address_" + address_id + "'href='/account/address-book/edit/" + address_id + "?prev_url=checkout' class='btn btn-primary btn-block edit_btn'>Edreereit</a>");
            }
        });
        sessionStorage.clear(); //clears session storage
    }




    //retrieves address details from database if option is selected
    $.each(addressArray, function(index, value) {

        $('#address_select').on('change', function() {

            if (this.value == value) {
                sessionStorage.setItem('selected', this.value);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/checkout/address/' + value,
                    method: 'GET',
                    success: function(response) {
                        var address_id = response[0]['address_id'];
                        var address_address = response[0]['address_address'];
                        var landmark = response[0]['landmark'];

                        $('.display_address').removeClass('d-none');
                        $("#address").empty();
                        $("#landmark").empty();
                        $("#edit_btn").empty();
                        $("#state_country").empty();
                        $("#address").append("<p>" + address_address + "</p>");
                        $("#landmark").append("<p>Near " + landmark + "</p>");
                        $("#state_country").append("<p>Akwa Ibom State, Nigeria.</p>");
                        $("#edit_btn").append("<a id='edit_address_" + address_id + "'href='/account/address-book/edit/" + address_id + "?prev_url=checkout' class='btn btn-primary btn-block edit_btn'>Edit</a>");

                    }
                });
            } else {
                $('.display_address').addClass('d-none');
            }
        })



    });



    //proceeds to checkout
    $('#pay').on('click', function() {
        $('#delivery_address_id').val($('#address_select').val());
        setTimeout(function() {
            if ($('#delivery_address_id').val() == "") {
                $('#payment_error').empty();
                $('#payment_error').append('* Please select a delivery address');
            } else {
                $('#paystack_form').submit();
            }
        }, 1000);
    });



    //email verified check
    $('#pay_null').on('click', function() {
        $('#delivery_address_id').val($('#address_select').val());
        setTimeout(function() {
            if ($('#delivery_address_id').val() == "") {
                $('#payment_error').empty();
                $('#payment_error_null').append('* Please verify your email address.');
            } else {
                $('#paystack_form').submit();
            }
        }, 1000);
    });
});