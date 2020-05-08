@extends('store.layouts.melamart')

@section('title')
<title>Buy {{$product->title}}</title>
@endsection

@section('itempage')
<!-- single-product-area start-->
<div class="single-product-area ptb-100">
    <div class="container">
        <div class="row b-shadow row-style">
            <div class="col-lg-3 col-sm-4">
                <div class="product-single-img">
                    <div class="product-active owl-carousel">
                        @foreach($product->images as $image)
                        <div class="item">
                            <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="">
                        </div>
                        @endforeach
                    </div>
                    <div class="product-thumbnil-active  owl-carousel">
                        @foreach($product->images as $image)
                        <div class="item">
                            <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-sm-8">
                <div class="product-single-content">
                    <h3>{{$product->title}}</h3>
                    <div class="rating-wrap fix">
                        <span class="pull-left price">&#8358;<?php echo number_format($product->total_price) ?></span>
                        @if ($product->discount != 0)
                        <span class="initial">&#8358;<?php echo number_format($product->initial_price) ?></span>
                        @endif
                        <ul class="rating pull-right">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li>(05 Customar Review)</li>
                        </ul>
                    </div>
                    <div class="brief-description">
                        {!! $product->brief_description !!}
                    </div>
                    <ul class="input-style">
                        <li><a id="add_to_cart_btn" href="javascript:void(0);">Add to Cart</a></li>
                        <li><a id="add_to_wishlist_btn" href="javascript:void(0);">Add to Wishlist</a></li>
                        <!-- form to add item to cart start -->
                        <form id="add_item_to_cart" action="/item/add-to-cart" method="POST">
                            @csrf
                            @guest
                            <input type="number" name="product_id" hidden value="{{ $product->id }}">
                            @else
                            <input type="number" name="user_id" hidden value="{{ Auth::user()->id }}">
                            <input type="number" name="product_id" hidden value="{{ $product->id }}">
                            @endguest
                        </form>
                        <!-- form to add item to cart end -->
                        <!-- form to add item to cart start -->
                        <form id="add_item_to_wishlist" action="/item/add-to-wishlist" method="POST">
                            @csrf
                            @guest
                            <input type="number" name="product_id" hidden value="{{ $product->id }}">
                            @else
                            <input type="number" name="user_id" hidden value="{{ Auth::user()->id }}">
                            <input type="number" name="product_id" hidden value="{{ $product->id }}">
                            @endguest
                        </form>
                        <!-- form to add item to cart end -->
                    </ul>
                    <ul class="cetagory">
                        <li>Category:</li>
                        <li><a href="/items/search?category={{$product->mainCategory->slug}}">{{$product->mainCategory->name}}</a></li>
                        <li>></li>
                        <li><a href="/items/search?category={{$product->mainCategory->slug}}&sub={{$product->subCategory->slug}}">{{$product->subCategory->name}}</a></li>
                    </ul>
                    <ul class="socil-icon">
                        <li>Share :</li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr class="divider visibility-none">
            <hr class="divider visibility-none">
        </div>
        <!--
        <div class="row mt-60">
            <div class="col-12">
                <div class="single-product-menu">
                    <ul class="nav">
                        <li><a class="active" data-toggle="tab" href="#description">Description</a> </li>
                        <li><a data-toggle="tab" href="#tag">Faq</a></li>
                        <li><a data-toggle="tab" href="#review">Review</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="tab-content b-shadow">
                    <div class="tab-pane active" id="description">
                        <div class="description-wrap">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6>Features</h6>
                                    <p>{!! $product->features !!}</p>
                                </div>
                                <div class="col-lg-6">
                                    <h6>Specifications</h6>
                                    <p>{!! $product->specifications !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tag">
                        <div class="faq-wrap" id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5><button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Return Policy?</button> </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        {{$product->returns}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5><button class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Shipping & Delivery ?</button></h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        {{$product->delivery}}
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingfive">
                                    <h5><button class="collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">General Inquiries ?</button></h5>
                                </div>
                                <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="review">
                        <div class="review-wrap">
                            <ul>
                                @foreach($product->feedbacks as $feedback)
                                <li class="review-items">
                                    <div class="review-img">
                                        <img src="{{ asset('images/comment/default.jpg') }}" alt="" class="img-width">
                                    </div>
                                    <div class="review-content">
                                        <h3><a href="#">ANON</a></h3>
                                        <span>{{$feedback->created_at->format('d M, Y')}} at {{$feedback->created_at->format('h:ia')}}</span>
                                        <p>{{ $feedback->feedback}}</p>
                                        <ul class="rating">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </li>
                                @endforeach
                                @if (count($product->feedbacks) == 0)
                                <h5>No feedback yet on this item.</h5>
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        -->
    </div>
</div>
<!-- single-product-area end-->
<!-- featured-product-area start -->
@include('store.helpers.related')
<!-- featured-product-area end -->
<!-- featured-product-area start -->
@include('store.helpers.advert')
<!-- featured-product-area end -->
@endsection