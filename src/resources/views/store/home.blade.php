@extends('store.layouts.melamart')

@section('title')
<title>MelaMart | Your No. 1 Online Grocery Store in Akwa Ibom</title>
@endsection

@section('homepage')
<!-- category-area start -->
<div class="banner-area pb-100 banner-area2">
    <div class="container">
        <div class="row banner-row">
            <!-- landing carousel start -->
            <div class="col-lg-9 col-md-9 col-sm-8 col-12">
                <div id="carousel-div" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-div" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-div" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="/images/banner/8.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/images/banner/7.jpg" alt="Second slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-div" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-div" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- landing carousel end -->
            <!-- gap on small screens start -->
            <div class="col-12 d-sm-none">
                <hr class="divider visibility-none">
            </div>
            <!-- gap on small screens end -->
            <!-- landing side image start -->
            <div class="col-lg-3 col-md-3 col-sm-4 col-12 text-center">
                <div class="banner-1">
                    <img src="/images/banner/6.jpg" alt="">
                </div>
            </div>
            <!-- landing side image end -->
        </div>
    </div>
</div>
<!-- category-area start -->
<div class="banner-area pb-100 banner-area2  hidden-md-down">
    <div class="container">
        <div class="col-12">
            <div class="section-title">
                <h1>Top Categories <span class="floatright"> <a href="/items/search?category=all">view all</a></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" id="category-div">
            @foreach ($allCategories as $key => $category)
            <?php if ($key < 10) { ?>
                <div class="col-1-2 col-6 col-padding">
                    <a id="cat{{$category->id}}" href="/items/search?category={{$category->slug}}" class="{{ request()->is("items/category/{$category->slug}") ? 'active' : ''}}">
                        <div class="category-div b-shadow">
                            {{$category->name}}
                        </div>
                    </a>
                </div>
            <?php }; ?>
            @endforeach
        </div>
    </div>
</div>
<!-- category-area end -->
<!-- featured-product-area start -->
@include('store.helpers.featured')
<!-- featured-product-area end -->
<!-- banner-area start -->
@include('store.helpers.advert')
<!-- banner-area end -->
<!-- featured-product-area start (new arrivals) -->
@include('store.helpers.newarrivals')
<!-- featured-product-area end (new arrivals) -->
<!-- banner-area start -->
@include('store.helpers.advert')
<!-- banner-area end -->
<!-- featured-product-area start (best deals) -->
@include('store.helpers.bestdeals')
<!-- featured-product-area end (best deals) -->
<!-- brief description start -->
<div class="banner-area pb-100 banner-area2">
    <div class="container">
        <div class="row b-shadow row-style">
            <p>
                <strong> MelaMart: Online Grocery Store in Lagos and Online Supermarket</strong><br>

                MelaMart, is the leading online supermarket and grocery delivery service in Nigeria. Order online from
                over 10,000 groceries and receive same-day delivery. Visit your favorite online grocery store, MelaMart,
                for the best online same day delivery shopping in Nigeria. On MelaMart, you can buy groceries online and
                get the best food shopping offers compared to any other online supermarket in Nigeria. This online
                grocery store in Lagos is great for grocery shopping and home delivery service. Online grocery shopping
                should be easy and that’s what we do best at MelaMart – we ensure that in our online supermarket in
                Lagos, you not only get great food shopping online offers, super market delivery but also the kind of
                excellent service you expect in an online food store. Shop here to get the best prices and discounts on
                food, beverages and household products when you do your online grocery shopping in Lagos or from
                anywhere in Nigeria. <br>

                Our wide selection of groceries includes product categories like fruits, vegetables, meat, chicken,
                fish, toiletries, beauty products, cosmetics, cleaning products, snacks, drinks, alcohol, canned goods,
                medicines, books, office supplies and lots more. Because we have the largest assortment of groceries in
                Nigeria, you'll be sure to find everyday essentials like bread, eggs, tea, cooking oil, sardines, garri,
                yam, carrots, apples, avocado, cornflakes, noodles, tea, coffee, soft drinks, juice, soap, deodorants,
                toothpaste, bleach, air fresheners, diapers, hand wash, toilet tissue, pens, printing paper and so much
                more. MelaMart is the only grocery supermarket where you can fulfill your entire shopping basket without
                having to drive to various stores and that's because we have all the leading brands like Coke, Fanta,
                Nescafe, Indomie, Power Oil, Ola Ola, Honeywell, Indomie, Peak, Golden Morn, Heinz, Milo, Lipton, Jik,
                Hypo, Ariel, Kellogg's, Nutzy, De Rica, Mamador, Gulder, Heineken, Orijin, Chivita, Dano, Oldenburger,
                Hollandia, Boulos, Nivea, Vaseline, Colgate, Pringles, McVities, Air Wick, Dettol. We're a one-stop shop
                near you, your very own grocery list app; it doesn't matter what part of your home you're thinking of,
                we've got the products for your kitchen, living room, bathroom, bedroom and even the office. <br>

                MelaMart has all the groceries you’ll find in supermarkets and retailers like Park N Shop, Spar,
                Hubmart, Shoprite, Ebeano, 9 to 7 by Save Mart, Nars, Medvacc Pharmacy, MedPlus Pharmacy, Mega Plaza
                Supermarket, Laterna Books, Office R Us, Office Everything, The Fish Shop, Chi Shoppe. With all this,
                you should ask yourself - why go to the supermarket when MelaMart can come to you? Buy your groceries
                online on MelaMart today!
            </p>
        </div>
    </div>
</div>
<!-- brief description end -->
@endsection