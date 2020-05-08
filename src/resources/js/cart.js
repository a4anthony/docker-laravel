$(document).ready(function() {
    //for (var i = 0; i < id.length; i++) {
    $.each(id, function(index, value) {
        //console.log(value);
        $("#result").append(index + ": " + value + '<br>');
        //$(".cart-plus-minus" + value).append('<div class="dec qtybutton qtybutton' + value + '">-</div><div class="inc qtybutton qtybutton' + value + '">+</div>');
        $(".qtybutton_cart" + value).on("click", function() {
            //var $input = $('#quantity' + value);
            var $button = $(this);
            var oldValue = $('#quantity' + value).val();
            if ($button.text() == "+") {
                if (oldValue < 10) {
                    var newVal = parseFloat(oldValue) + 1;
                    $('#quantity' + value).val(newVal);
                    //$('#update_quantity' + value).submit();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/cart/update/' + value + '/' + newVal,
                        method: 'PUT',
                        success: function(response) {
                            $('#total_price' + value).html('<span> &#8358;</span>' + response.total);
                            $('#item_total' + value).html('<span> &#8358;</span>' + response.total);
                            $('#item_initial' + value).html('<span> &#8358;</span>' + response.initialTotal);
                            $('#item_total_bg' + value).html('<span> &#8358;</span>' + response.total);
                            $('#item_initial_bg' + value).html('<span> &#8358;</span>' + response.initialTotal);
                            $('#cart_total').html('<span class="pull-left"> Total </span><span>&#8358;' + response.cartTotal + '</span>');
                            $('#cart_total_sub').html('<span class="pull-left"> Subtotal </span><span>&#8358;' + response.cartTotal + '</span>');
                        }
                    });
                } else {
                    var newVal = 10;
                }
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 1) {
                    var newVal = parseFloat(oldValue) - 1;
                    $('#quantity' + value).val(newVal);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/cart/update/' + value + '/' + newVal,
                        method: 'PUT',
                        //data: $('#add_item_to_cart').serialize(),
                        success: function(response) {
                            $('#total_price' + value).html('<span> &#8358;</span>' + response.total);
                            $('#item_total' + value).html('<span> &#8358;</span>' + response.total);
                            $('#item_initial' + value).html('<span> &#8358;</span>' + response.initialTotal);
                            $('#item_total_bg' + value).html('<span> &#8358;</span>' + response.total);
                            $('#item_initial_bg' + value).html('<span> &#8358;</span>' + response.initialTotal);
                            $('#cart_total').html('<span class="pull-left"> Total </span><span>&#8358;' + response.cartTotal + '</span>');
                            $('#cart_total_sub').html('<span class="pull-left"> Subtotal </span><span>&#8358;' + response.cartTotal + '</span>');
                        }
                    });
                } else {
                    newVal = 1;
                }
            }
            $button.parent().find("input").val(newVal);
        });
    });
    //};
});