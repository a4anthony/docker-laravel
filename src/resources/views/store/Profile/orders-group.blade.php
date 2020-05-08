@extends('store.Profile.index')

@section('title')
<title>Orders | MelaMart</title>
@endsection

@section('dashboard')
<!-- cart-area start -->
<div class="cart-area ptb-100 background b-shadow no-shadow">
    <div class="container">
        <!-- page title start -->
        <div class="row">
            <div class="col-12 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5>Orders</h5>
            </div>
        </div>
        <!-- page title end -->
        @if (count($arrayOrdersByReference) != 0)
        <div class="paginate-results">
            <p>Showing {{ $arrayOrdersByReference->firstItem() }} to {{ $arrayOrdersByReference->lastItem() }} of {{$arrayOrdersByReference->total()}}
                orders
            </p>
        </div>
        @endif
        <div class="row">
            @if(count($arrayOrdersByReference) != 0)
            @foreach($arrayOrdersByReference as $key => $ordersByReference)
            @foreach($ordersByReference as $orders)
            @foreach($orders as $key => $order)
            @if ($key == 0)
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="content fix-orders-height m-bottom">
                    <h5>Order date: {{$order->created_at->format('d-m-Y')}}<span class="floatright"> <a href="/account/orders?reference={{$order->reference}}">view order</a></h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <p><span class="span-header">Payment Reference:</span> {{$order->reference}}</p>
                                <p><span class="span-header">Amount:</span> <span>&#8358;</span><?php echo (number_format($order->total($order))); ?></p>
                                <p><span class="span-header">Total Items:</span> <?php echo count($order->products($order)); ?></p>
                                <p><span class="span-header">Delivery Address:</span> {{$order->address}}</p>
                            </div>
                            @foreach($order->products($order) as $productKey => $product)
                            <!-- if images are <= 6 -->
                            <?php if (count($order->products($order)) <= 6) { ?>
                                <div class="col-1 no-margin no-padding">
                                    @foreach ($product->images as $key => $image)
                                    <?php //dd($order->products($order)); 
                                    ?>
                                    <a href="/item/{{ $product->slug}}">
                                        @if ($key == 0)
                                        <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="{{ $product->slug}}" class="img-fluid">
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                            <?php }; ?>
                            <!-- if images are > 6 -->
                            <?php if (count($order->products($order)) > 6) { ?>
                                <?php if ($productKey <= 7) { ?>
                                    <div class="col-1 no-margin no-padding">
                                        @foreach ($product->images as $key => $image)
                                        <a href="/item/{{ $product->slug}}">
                                            @if ($key == 0)
                                            <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="{{ $product->slug}}" class="img-fluid" >
                                            @endif
                                        </a>
                                        @endforeach
                                    </div>
                                <?php   }; ?>
                                <?php if ($productKey == 8) { ?>
                                    <div class="col-1 no-margin no-padding">
                                        @foreach ($product->images as $key => $image)
                                        <?php if ($productKey == 8) { ?>
                                            <a href="/item/{{ $product->slug}}">
                                                @if ($key == 0)
                                                <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="{{ $product->slug}}" class="img-fluid img-opacity">
                                                @endif
                                            </a>
                                        <?php   }; ?>
                                        @endforeach
                                    </div>
                                <?php   }; ?>
                            <?php   }; ?>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endforeach
            @endforeach
            @else 
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 empty">
                <h6>Oops! you are yet to place your first order.</h6>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- cart-area end -->
<!-- pagination area start -->
<nav class="blog-pagination justify-content-center d-flex ">
    <ul class="pagination d-block d-sm-none">
        {{ $arrayOrdersByReference->appends(Request::except('page'))->links('store.vendor.pagination.bootstrap-sm')  }}
    </ul>
    <ul class="pagination d-none d-md-block">
        {{ $arrayOrdersByReference->appends(Request::except('page'))->links()  }}
    </ul>
</nav>
<!-- pagination area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection