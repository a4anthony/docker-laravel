<div class="featured-product-area {{ request()->is('account') ? 'hide-nav' : ''}}">

    <div class="container">
        <div class="col-12">
            <div class="section-title">
                <h1>Featured Products <span style="float: right;"> <a href="">view more</a> </span>
                </h1>
            </div>
        </div>
    </div>


    <div class="container container-scroll">

        <div class="row row-scroll">
            @foreach($array_featured_products as $product)
            <div class="col-lg-2 col-sm-2 col-2" style="margin:0; padding: .4rem;">
                <div class="product-div b-shadow">

                    <div class="featured-product-wrap">
                        <div class="featured-product-img">
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


                        <div class="featured-product-content">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="wrap-text">
                                        <a href="/item/{{ $product->slug }}">
                                            {{$product->title}}
                                        </a>
                                    </h3>
                                    <span class="pull-left total"> <span> &#8358;</span><?php echo (number_format($product->total_price)); ?></span>
                                    @if ($product->discount > 0)
                                    <span class="pull-left initial"> <span> &#8358;</span><?php echo (number_format($product->initial_price)); ?></span>
                                    @endif

                                </div>

                            </div>
                        </div>


                        <!-- item-action start -->
                        @include('store.helpers.item-action')
                        <!-- item-action end -->

                    </div>


                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>