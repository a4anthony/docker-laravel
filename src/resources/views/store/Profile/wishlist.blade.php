@extends('store.Profile.index')

@section('title')
<title>Wishlist | MelaMart</title>
@endsection

@section('wishlist')
<!-- cart-area start -->
<div class="cart-area ptb-100 background b-shadow no-shadow profile-tab">
    <div class="container">
        <!-- page title start -->
        <div class="row">
            <div class="col-12 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5>Wishlist</h5>
            </div>
        </div>
        <!-- page title end -->
        @if (count($arrayWishlist) != 0)
        <div class="no-padding paginate-results">
            <p>Showing {{ $arrayWishlist->firstItem() }} to {{ $arrayWishlist->lastItem() }} of {{$arrayWishlist->total()}}
                items
            </p>
        </div>
        @endif
        <div class="row">
            @if (count($arrayWishlist) != 0)
            @foreach($arrayWishlist as $wishlist)
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 m-bottom">
                <div class="content div-padding fix-height">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-3  text-center">
                                @foreach ($wishlist->product->images as $key => $image)
                                @if( $key == 0)
                                <img class="images" src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="" class="img-fluid img-width">
                                @endif
                                @endforeach
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-9 my-auto-sm ">
                                <p class="product"><a href="/item/{{$wishlist->product->slug}}}">{{$wishlist->product->title}}</a></p>
                                <span class="pull-left total"> <span> &#8358;</span><?php echo (number_format($wishlist->product->total_price)); ?></span>
                                <span class="pull-left initial"> <span> &#8358;</span><?php echo (number_format($wishlist->product->initial_price)); ?></span><br>
                            </div>
                            <div class="action-btn wishlist">
                                <div class="text-center featured-product-content no-padding-top">
                                    <ul>
                                        <li><a href="" onclick="event.preventDefault();
                                             document.getElementById('add_item_to_cart{{$wishlist->product->id}}').submit();"><i class="fa fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                        <li><a href="" onclick="event.preventDefault();
                                            document.getElementById('delWishlist{{$wishlist->product->id}}').submit();"><i class="fa fa-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- form to add item to wishlist start -->
                                <form id="add_item_to_cart{{$wishlist->product->id}}" action="/item/add-to-cart" method="POST">
                                    @csrf
                                    @guest
                                    <input type="number" name="product_id" hidden value="{{ $product->id }}">
                                    @else
                                    <input type="number" name="user_id" hidden value="{{ Auth::user()->id }}">
                                    <input type="number" name="product_id" hidden value="{{ $wishlist->product->id }}">
                                    @endguest
                                </form>
                                <!-- form to add item to wishlist end -->
                                <!-- form to delete item from wishlist start -->
                                <form id="delWishlist{{$wishlist->product->id}}" action="/wishlist/delete/{{$wishlist->product->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="number" name="product_id" hidden value="{{$wishlist->product->id}}">
                                </form>
                                <!-- form to delete item from wishlist end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 empty">
                <h6>Oops! no item(s) in wishlist yet.</h6>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- cart-area end -->
<!-- pagination area start -->
<nav class="blog-pagination justify-content-center d-flex ">
    <ul class="pagination d-block d-sm-none">
        {{ $arrayWishlist->appends(Request::except('page'))->links('store.vendor.pagination.bootstrap-sm')  }}
    </ul>
    <ul class="pagination d-none d-md-block">
        {{ $arrayWishlist->appends(Request::except('page'))->links()  }}
    </ul>
</nav>
<!-- pagination area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection