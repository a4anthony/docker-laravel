<form id="add_item_to_cart_form" action="/item/add-to-cart" method="POST">
    @csrf
    @guest
    @else
    <input type="number" name="user_id" hidden value="{{ Auth::user()->id }}">
    @endguest
    <input type="number" id="product_id_cart"  name="product_id" hidden value="">
</form>
<!-- form to add item to cart end -->
<!-- form to add item to cart start -->
<form id="add_item_to_wishlist_form" action="/item/add-to-wishlist" method="POST">
    @csrf
    @guest
    @else
    <input type="number" name="user_id" hidden value="{{ Auth::user()->id }}">
    @endguest
    <input type="number" id="product_id_wishlist"  name="product_id" hidden value="">

</form>