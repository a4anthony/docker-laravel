@extends('store.layouts.melamart')

@section('title')
<title>Shop | MelaMart</title>
@endsection
@section('scripts')
<script>
    var url = <?php echo json_encode($url); ?>;
    var catslug = <?php echo json_encode($slugCat); ?>;
    var id = <?php echo json_encode($allCategories); ?>;
</script>
@endsection
@section('shoppage')
<!-- product-area start -->
<div class="product-area ptb-100 product-sidebar-area">
    <div class="container-fluid">
        <div class="row revarce-wrap">
            <!-- side tab start -->
            <div class="col-lg-3 col-12">
                <aside class="sidebar-area">
                    <!-- categories side tab start -->
                    <div class="widget widget_categories d-none d-lg-block b-shadow">
                        <h4 class="widget-title ">Categories</h4>
                        <ul>
                            @foreach ($allCategories as $category)
                            <li>
                                <a id="category{{$category->id}}" href="javascript:void(0);" class="{{ request()->is("items/search?category={$category->slug}") ? 'd-none' : ''}}">
                                    <span class="iconify" data-icon="ic:baseline-greater-than" data-inline="false"></span>
                                    {{$category->name}}
                                </a>
                            </li>
                            <ul id="subList{{$category->id}}" class="d-none">
                                @foreach ($category->subCategory as $subCategory)
                                <li class="categories"><a id="subCategory{{$subCategory->id}}" href="javascript:void(0);" class="{{$subCategory->slug}}">{{$subCategory->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            @endforeach
                        </ul>
                    </div>
                    <!-- categories side tab end -->
                    <!-- related products start -->
                    <div class="widget widget_recent_entries b-shadow">
                        <h4 class="widget-title">Related Products</h4>
                        <ul>
                            @foreach($array_featured_products as $product)
                            <li>
                                <div class="post-img">
                                    @foreach ($product->images as $key => $image)
                                    <a href="/item/{{ $product->slug}}">
                                        @if ($key == 0)
                                        <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="" class="img-fluid img-width-sm">
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                                <div class="post-content">
                                    <p class="wrap-text">
                                        <a href="/item/{{ $product->slug }}"> {{ $product->title}}</a>
                                    </p>
                                    <span class="pull-left total"> &#8358;<?php echo (number_format($product->total_price)); ?></span>
                                    <span class="pull-left initial"> &#8358;<?php echo (number_format($product->initial_price)); ?></span><br>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- related products end -->
                </aside>
            </div>
            <!-- side tab end -->
            <!-- main tab start -->
            <div class="col-lg-9 col-12">
                <div class="row mb-30 b-shadow">
                    <!-- categories small screen start -->
                    <div class="col-lg-3 col-sm-6 col-12 d-block d-lg-none">
                        <select name="" id="selectSortCat" class="select-style">
                            <option value="">-- Select Category --</option>
                            @foreach ($allCategories as $category)
                            <option id="option{{$category->id}}" value="{{$category->slug}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-block d-lg-none">
                        <select name="" id="dummy-list" class="select-style">
                            <option value="">-- Select sub-category --</option>
                        </select>
                        @foreach ($allCategories as $category)
                        <select name="" id="selectSortSubCat{{$category->id}}" class="select-style d-none">
                            <option value="">-- Select sub-category --</option>
                            @foreach ($category->subCategory as $subCategory)
                            <option value="{{$subCategory->slug}}">{{$subCategory->name}}</option>
                            @endforeach
                        </select>
                        @endforeach
                    </div>
                    <!-- categories small screen end -->
                    <!-- white space -->
                    <div class="col-12 d-none d-md-block d-lg-none">
                        <hr class="divider visibility-none">
                    </div>
                    <!-- sort by start -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <form id="sortForm" action="{{$url}}" method="GET">
                            <select name="sortby" id="selectSort" class="select-style">
                                <option value="relevant">Relevant</option>
                                <option value="high-to-low">Price: high to low</option>
                                <option value="low-to-high">Price: low to high</option>
                            </select>
                        </form>
                    </div>
                    <!-- sort by end-->
                    <!-- results count start -->
                    <div class=" col-lg-4 col-sm-6 col-12 d-none d-lg-block">
                        <p class="total-product">
                            @if (count($arrayProducts) != 0)
                            Showing {{ $arrayProducts->firstItem() }} to {{ $arrayProducts->lastItem() }} of
                            {{$arrayProducts->total()}} Results
                            @else
                            No search result
                            @endif
                        </p>
                    </div>
                    <!-- results count end -->
                    <!-- price filter start-->
                    <div class="col-sm-6 col-lg-5 col-12 my-auto ">
                        <div class="filter-price no-margin no-padding">
                            <form action="{{$url}}" method="GET">
                                <div class="row">
                                    <div class="col-8">
                                        <div id="slider-range" class=" no-margin no-padding"></div>
                                        <p class=" no-margin no-padding">
                                            <span> (Amount in &#8358;)
                                            </span><input type="text" id="amount" name="amount" readonly>
                                        </p>
                                    </div>
                                    <div class="col-4 text-right">
                                        <button id="price-btn" onclick="event.preventDefault();">filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- price filter end -->
                    <!-- results (small-screen) start -->
                    <div class="col-12 d-block d-lg-none">
                        <p class="total-product">
                            @if (count($arrayProducts) != 0)
                            Showing {{ $arrayProducts->firstItem() }} to {{ $arrayProducts->lastItem() }} of
                            {{$arrayProducts->total()}} Results
                            @else
                            No search result
                            @endif
                        </p>
                    </div>
                    <!-- results (small-screen) end -->
                </div>
                <!-- search results start -->
                <div class="tab-content">
                    <div class="tab-pane active" id="grid">
                        <ul class="row">
                            @if(count($arrayProducts) != 0)
                            @foreach ($arrayProducts as $product)
                            <li class="col-lg-3 col-md-2 col-sm-3 col-6 product-col">
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
                                    <!-- item-action start -->
                                    @include('store.helpers.item-action')
                                    <!-- item-action end -->
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
                        <!-- pagination area start -->
                        <div class="row">
                            <div class="col-12">
                                <nav class="blog-pagination justify-content-center d-flex ">
                                    <ul class="pagination d-block d-sm-none">
                                        {{ $arrayProducts->appends(Request::except('page'))->links('store.vendor.pagination.bootstrap-sm')  }}
                                    </ul>
                                    <ul class="pagination d-none d-md-block">
                                        {{ $arrayProducts->appends(Request::except('page'))->links()  }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- pagination area end -->
                    </div>

                </div>
                <!-- search results end -->
            </div>
            <!-- main tab end -->
        </div>
    </div>
</div>
<!-- product-area end -->
@section('shop-js')
<script src="{{ mix('/js/shop.js') }}"></script>
@endsection
@endsection