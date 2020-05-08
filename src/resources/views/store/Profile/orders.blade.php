@extends('store.Profile.index')

@section('title')
<title>Orders | MelaMart</title>
@endsection

@section('dashboard')
<!-- cart-area start -->
<div class="cart-area ptb-100 background b-shadow no-shadow">
    <div class="container">
        <!-- page title start -->
        <div class="row  {{ request()->is('account/address-book/add*') ? 'top-pad' : ''}}">
            <div class="col-lg-1 col-md-1  col-sm-1 col-1 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <a href="/account/orders" style="font-size: 2rem; color: #333;">
                    <span class="iconify" data-icon="bx:bx-arrow-back" data-inline="false"></span>
                </a>
            </div>
            <div class="col-lg-4 col-md-4  col-sm-4 col-6 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5 class="no-margin">Orders</h5>
            </div>
        </div>
        <!-- page title end -->
        @if (count($arrayOrders) != 0)
        <div class="paginate-results">
            <p>Showing {{ $arrayOrders->firstItem() }} to {{ $arrayOrders->lastItem() }} of {{$arrayOrders->total()}}
                orders
            </p>
        </div>
        @endif
        <div class="row">
            @foreach($arrayOrders as $order)
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="content fix-orders-height m-bottom">
                    <h5>Order date: {{$order->created_at->format('d-m-Y')}}<span class="floatright">Reference: {{$order->reference}}</a></h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-2  text-center no-margin no-padding my-auto">
                                @foreach ($order->product->images as $key => $image)
                                @if( $key == 0)
                                <img class="images" src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="" class="img-fluid img-width">
                                @endif
                                @endforeach
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-10 col-10 my-auto">
                                <p class="product"><a href="/item/{{$order->product->slug}}">{{$order->product->title}}</a></p>
                                <p><span class="span-header">Amount:</span> <span>&#8358;</span><?php echo (number_format($order->price)); ?></p>
                                <p><span class="span-header">Quantity:</span> {{$order->quantity}}</p>
                            </div>

                            <div class="action-btn orders">
                                <div class="text-center featured-product-content no-padding-top">
                                    <ul>
                                        <li><a href="/account/orders/feedback/{{$order->product->id}}"><i class="fa fa-comment"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- cart-area end -->
<!-- pagination area start -->
<nav class="blog-pagination justify-content-center d-flex ">
    <ul class="pagination d-block d-sm-none">
        {{ $arrayOrders->appends(Request::except('page'))->links('store.vendor.pagination.bootstrap-sm')  }}
    </ul>
    <ul class="pagination d-none d-md-block">
        {{ $arrayOrders->appends(Request::except('page'))->links()  }}
    </ul>
</nav>
<!-- pagination area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection