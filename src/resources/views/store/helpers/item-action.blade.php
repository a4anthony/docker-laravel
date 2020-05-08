<div class="text-center featured-product-content" style="padding-top: 0;">
    <ul>
        <li><a href="javascript:void(0);" class="add_to_cart_btn{{$product->id}}"><i class="fa fa-shopping-cart"></i></a></li>
        <li class="space"></li>
        <li><a href="javascript:void(0);" class="add_to_wishlist_btn{{$product->id}}"><i class="fa fa-heart"></i></a></li>
    </ul>
</div>

<!-- form to add item to cart end -->

@section('cart-js')
<script>
    $(document).ready(function() {
        function range(start, end) {
            var myArray = [];
            for (var i = start; i <= end; i += 1) {
                myArray.push(i);
            }
            return myArray;
        };


        $.each(range(1, 5000), function(index, value) {
            $(".add_to_cart_btn" + value).on('click', function() {
                addToCart(value);
            });
        });


        function addToCart(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#product_id_cart').val('');
            $('#product_id_cart').val(id);

            $(".add_to_cart_btn" + id).addClass('zoom');
            setTimeout(function() {

                $.ajax({
                    url: "/item/add-to-cart",
                    method: 'POST',
                    data: $('#add_item_to_cart_form').serialize(),
                    success: function(response) {
                        $(".add_to_cart_btn" + id).removeClass('zoom');
                        $('.cart-count').html(response.count_cartItems);
                        $('.featured-product-content ul .add_to_cart_btn' + id).css("border", "1px solid green");
                        $('.featured-product-content ul .add_to_cart_btn' + id).css("background", "white");
                        $('.featured-product-content ul .add_to_cart_btn' + id).css("color", "green");
                    }
                });
            }, 2000);


        }



        $.each(range(1, 5000), function(index, value) {
            $(".add_to_wishlist_btn" + value).on('click', function() {
                addToWishlist(value);
            });
        });


        function addToWishlist(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#product_id_wishlist').val('');
            $('#product_id_wishlist').val(id);

            $(".add_to_wishlist_btn" + id).addClass('zoom');
            setTimeout(function() {

                $.ajax({
                    url: "/item/add-to-wishlist",
                    method: 'POST',
                    data: $('#add_item_to_wishlist_form').serialize(),
                    success: function(response) {
                        $(".add_to_wishlist_btn" + id).removeClass('zoom');
                        $('.cart-count').html(response.count_cartItems);
                        $('.featured-product-content ul .add_to_wishlist_btn' + id).css("border", "1px solid green");
                        $('.featured-product-content ul .add_to_wishlist_btn' + id).css("background", "white");
                        $('.featured-product-content ul .add_to_wishlist_btn' + id).css("color", "green");
                    }
                });
            }, 2000);


        }
    });
</script>
@endsection