@extends('store.layouts.melamart')

@section('title')
<title>Shop | MelaMart</title>
@endsection

@section('shoppage')
<style>
    .header-area,
    .footer-area {
        display: none;
    }
</style>
<!-- product-area start -->
<div class="product-area ptb-100 product-sidebar-area">
    <div class="container-fluid">
        <div class="row">
            <!-- side tab start -->
            <div class="col-lg-12">
                <!-- search results start -->
                <div class="tab-content">
                    <div class="tab-pane active" id="grid">
                        <ul class="row">
                            @if(count($arrayProducts) != 0)
                            @foreach ($arrayProducts as $product)
                            <li class="col-lg-2 product-col">
                                <div class="product-wrap product-div b-shadow">
                                    <a href="/item/{{ $product->slug }}">
                                        <a href="/item/{{ $product->slug}}">
                                            <div class="product-img">
                                                @foreach ($product->images as $key => $image)
                                                <a href="/item/{{ $product->slug}}">
                                                    @if ($key == 0)
                                                    <picture>
                                                        @foreach ($product->imagesWebp as $key => $imageWebp)
                                                        @if ($key == 0)
                                                        <source srcset="{{env('IMAGE_URL')}}{{$imageWebp->image_link}}" type="image/webp">
                                                        @endif
                                                        @endforeach
                                                        <source srcset="{{env('IMAGE_URL')}}{{$image->image_link}}" type="image/jpeg">
                                                        <img alt="{{ $product->slug}}" src="{{env('IMAGE_URL')}}{{$image->image_link}}">
                                                    </picture>
                                                    @endif
                                                </a>
                                                @endforeach
                                            </div>
                                        </a>
                                    </a>
                                    <div class="product-content fix">
                                        <h3 class="wrap-text"><a href="/item/{{ $product->slug }}">{{$product->title}}</a></h3>
                                        <span class="pull-left total"> &#8358;<?php echo (number_format($product->total_price)); ?></span>
                                        @if ($product->discount > 0)
                                        <span class="pull-left initial"> <span> &#8358;</span><?php echo (number_format($product->initial_price)); ?></span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                            @else
                            <li>
                                <div class="col-12 text-center">
                                    <h6>No search result.</h6>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>

                </div>
                <!-- search results end -->
            </div>
            <!-- main tab end -->
        </div>
    </div>
</div>
<!-- product-area end -->
@endsection