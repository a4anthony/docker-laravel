<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- page title -->
    @yield('title')
    <!-- meta tags for page -->
    @yield('meta')
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}">
    <!-- Place favicon.ico in the root directory -->

    <!-- all css here -->
    <link rel="stylesheet" href="{{ mix('/css/mart-app.css') }}">

    <!-- modernizr css -->
    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}" defer></script>

    <script src="https://code.iconify.design/1/1.0.6/iconify.min.js"></script>
    <script>
        var imageUrl = <?php echo json_encode(env('IMAGE_URL')); ?>;
    </script>
    @yield('scripts')

</head>

<body>
    <!--Start Preloader-->
    <div class="preloader-wrap">
        <div class="spinner">
            <img src="{{asset('images/logo_sq.png')}}" alt="" class="img-fluid">
        </div>
    </div>
    <!-- Collapsible content start -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent23">
        <div class="navbar-div">
            <!-- Links -->
            <hr>
            <strong>Account</strong>
            <ul class="navbar-nav mr-auto">
                <li>
                    <a href="/account/orders">
                        <span class="iconify" data-icon="ic:baseline-greater-than" data-inline="false"></span>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="/account/wishlist">
                        <span class="iconify" data-icon="ic:baseline-greater-than" data-inline="false"></span>
                        Wishlist
                    </a>
                </li>
            </ul>
            <hr>
            <!-- Links -->
            <strong>Categories</strong>
            <ul class="navbar-nav mr-auto">
                @foreach ($allCategories as $category)
                <li><a id="cat{{$category->id}}" href="/items/search?category={{$category->slug}}" class="{{ request()->is("items/category/{$category->slug}") ? 'active' : ''}}">
                        <span class="iconify" data-icon="ic:baseline-greater-than" data-inline="false"></span>
                        {{$category->name}}
                    </a>
                </li>
                @endforeach
            </ul>
            <hr>
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li>
                    <a href="">Return policy</a>
                </li>
                <li>
                    <a href="">Delivery policy</a>
                </li>
                <li>
                    <a href="">Contact us</a>
                </li>
            </ul>
        </div>
        <!-- menu small screen overlay-->
        <div class="overlay"></div>
    </div>
    <!-- menu small screen overlay-->
    <div class="overlay-bottom d-none"></div>
    <!-- Collapsible content end -->

    <!-- Popup Subscribe Form -->
    @include('store.helpers.item-form')
    <!-- Popup Subscribe Form -->
    <!-- Popup Subscribe Form -->
    @include('store.helpers.item-popup')
    <!-- Popup Subscribe Form -->
    <!-- header-area start -->
    <header class="header-area {{ request()->is('account/*') ? 'hide-nav' : ''}}" id="sticky-header">
        <!-- top nav banner start -->
        <div class="d-none d-xl-block flash-div">
            <div class="row">
                <div class="col-3">
                    <div class="flash">
                        <i class="fa fa-envelope-o"></i> <a href="mailto: help@melamartonline.com">help@melamartonline.com</a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="flash">
                        <p><i class="fa fa-clock" aria-hidden="true"></i>We Deliver 7 Days A Week: 12-4 PM | 3-6 PM | 6-9 PM</p>
                    </div>
                </div>
                <div class="col-5">
                    <div class="flash">
                        <p><i class="fa fa-map-marker"></i> We currently only deliver to locations within Uyo town.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- top nav banner end -->
        <div class="container">
            <div class="row">
                <!-- menu button start -->
                <div class="col-lg-1 col-md-1 col-sm-1 clear col-2 my-auto {{ (request()->is('/')) ? 'd-none' : '' }} {{ (request()->is('/')) ? 'visible-md-down' : '' }}">
                    <!-- Collapse button -->
                    <button class="navbar-toggler second-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent23" aria-controls="navbarSupportedContent23" aria-expanded="false" aria-label="Toggle navigation">
                        <div class="animated-icon2"><span></span><span></span><span></span><span></span></div>
                    </button>
                </div>
                <!-- menu button end -->
                <!-- logo start -->
                <div class="col-lg-2 col-md-2 col-6">
                    <div class="search-wrapper logo {{ (request()->is('/')) ? 'reset-logo' : '' }}">
                        <ul class="d-flex">
                            <li>
                                <a href="/">
                                    <img src="{{asset('images/logo-200.png')}}" alt="" class="img-fluid">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- logo end -->
                <div class="  {{ (request()->is('/')) ? 'offset-lg-1' : '' }} {{ (request()->is('/')) ? 'hidden-md-down' : '' }}">
                </div>
                <!-- search bar start -->
                <div class="col-lg-5 col-md-6 d-none d-md-block">
                    <div class="search-div">
                        <form id="searchform" action="/autocomplete" method="GET">
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control" id="search" name="search" type="text" placeholder="Search products, brands and categories" autocomplete="off">
                                <div id="searchdiv" class="d-none">
                                    <ul>
                                    </ul>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary mela-btn" id="search-btn" type="button">SEARCH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- search bar end -->
                <!-- nav icons start -->
                <div class="col-lg-4 col-md-3 col-sm-4 col-4">
                    <div class="search-wrapper">
                        <ul class="d-flex">

                            <!-- user account -->
                            <li class="nav-hidden">
                                @guest
                                <a href="javascript:void(0);">
                                    <span class="iconify" data-icon="bx:bx-user" data-inline="false"></span>
                                </a>
                                @else
                                <a href="javascript:void(0);">
                                    <span class="hidden-md-down"> Hi, {{ Auth::user()->firstname }}</span> <span class="iconify" data-icon="bx:bx-user-check" data-inline="false"></span>
                                </a>
                                @endguest
                                <ul class="account-wrap">

                                    @guest
                                    <li><a href="/login">Login</a></li>
                                    <li><a href="/register">Register</a></li>
                                    <li><a href="/account">Account</a></li>
                                    <li><a href="/account/wishlist">wishlist</a></li>
                                    <li><a href="/account/orders">Orders</a></li>
                                    <li><a href="/checkout">Checkout</a></li>
                                    @else
                                    <li><a href="/account">Account</a></li>
                                    <li><a href="/account/wishlist">wishlist</a></li>
                                    <li><a href="/account/orders">Orders</a></li>
                                    <li><a href="/checkout">Checkout</a></li>
                                    <hr>
                                    <li> <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                    @endguest

                                </ul>
                            </li>

                            <!-- help -->
                            <li class="hidden-md-down nav-hidden">
                                <a href="javascript:void(0);">
                                    <span class="iconify" data-icon="ion:help-circle-outline" data-inline="false"></span>
                                </a>
                                <ul class="account-wrap">
                                    <li><a href="/policy/return">Return policy</a></li>
                                    <li><a href="/policy/delivery">Delivery policy</a></li>
                                    <li><a href="/contact">Contact us</a></li>
                                </ul>
                            </li>

                            <!-- cart -->
                            <li class="text-center nav-hidden">
                                <a href="/cart" class="text-center">
                                    <span class="iconify" data-icon="typcn-shopping-cart" data-inline="false"></span>
                                </a>
                                <div class="cart-circle">
                                    <span class="cart-count">{{$count_cart_items}}</span>
                                </div>
                            </li>

                        </ul>
                    </div>


                </div>
                <!-- nav icons end -->
                <!-- search for smaller screens start -->
                <div class="col-12 d-md-none">
                    <div class="search-div-sm">
                        <form id="searchform-sm" action="/autocomplete" method="GET">
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control" id="search-sm" name="search" type="text" placeholder="Search products, brands and categories" autocomplete="off">
                                <div id="searchdiv-sm" class="d-none">
                                    <ul>
                                    </ul>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary mela-btn" id="search-btn-sm" type="button"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- search for smaller screens end -->
            </div>
        </div>
    </header>
    <!-- header-area end -->
    <!-- homepage-area start-->
    @yield('homepage')
    <!-- homepage-area end -->
    <!-- login-area start -->
    @yield('loginpage')
    <!-- login-area end -->
    <!-- regiterpage-area start -->
    @yield('registerpage')
    <!-- register-area end -->
    <!-- itempage-area start -->
    @yield('itempage')
    <!-- itempage-area end -->
    <!-- profilepage-area start -->
    @yield('profilepage')
    <!-- profilepage-area end -->
    <!-- cartpage-area start -->
    @yield('cartpage')
    <!-- cartpage-area end -->
    <!-- checkoutpage-area start -->
    @yield('checkoutpage')
    <!-- checkoutpage-area end -->
    <!-- email-verified-area start -->
    @yield('email_verified')
    <!-- email-verified-area end -->
    <!-- password-reset-area start -->
    @yield('password_reset')
    <!-- password-reset-area end -->
    <!-- password-reset-area start -->
    @yield('shoppage')
    <!-- password-reset-area end -->
    <!-- footer-area start -->
    <footer class="footer-area">
        <div class="footer-top bg-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="footer-widget footer-menu">
                            <h2>Join us</h2>
                            <ul class="socil-icon d-flex">
                                <li><a rel="noopener" href="https://www.facebook.com/mela.mart.54" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li>
                                    <hr>
                                </li>
                                <li><a rel="noopener" href="https://twitter.com/melamart_ng" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <li><a rel="noopener" href="https://www.linkedin.com/company/37531404" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                <li><a rel="noopener" href="https://www.instagram.com/melamartonline/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="footer-widget footer-menu">
                            <h2>Quick links</h2>
                            <ul>
                                <li><a href="/account">My Account</a></li>
                                <li><a href="/cart">Cart</a></li>
                                <li><a href="javascript:void(0)">Help</a></li>
                                <li><a href="javascript:void(0)">Support</a></li>
                                <li><a href="javascript:void(0)">Returns policy</a></li>
                                <li><a href="javascript:void(0)">Delivery policy</a></li>
                                <li><a href="javascript:void(0)">Terms & conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="footer-widget footer-contact">
                            <h2>Contact us</h2>
                            <ul>
                                <li><i class="fa fa-map-marker contact"></i> Ekit Itam 11 Rd, Uyo, Akwa Ibom State Nigeria</li>
                                <li><i class="fa fa-phone contact"></i> +(234) 704-576-6325 <br> +(234) 802-319-9400 </li>
                                <li><i class="fa fa-envelope-o contact"></i> help@melamartonline.com</li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="footer-widget footer-contact">
                            <h2>Join Our Newsletter</h2>
                            <p>Be the first to hear about our deals and offers!</p>

                            <form id="subscribe-form" action="/subscribe" method="POST">
                                @csrf
                                <div class="form_msg">
                                    <label class="mt10" for="mc-email"></label>
                                </div>
                                <input type="email" name="email" placeholder="Enter Your Email" required>
                                <button onclick="event.preventDefault();" class="subscribe-btn mela-btn"><i class="fa fa-long-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-buttom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12 text-center">
                        <p>&copy;2020 MelaMart All Right Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-area end -->
    <script src="{{ mix('/js/mart-app.js') }}"></script>
    <!-- all scripts -->
    <!-- cart quantity js -->
    @yield('cart-quantity-js')
    <!-- checkout address js -->
    @yield('checkout-address-js')
    <!-- verify redirect js -->
    @yield('redirect-js')
    <!-- search js -->
    @yield('shop-js')
    <!-- contact map js -->
    @yield('contact-map-js')
    <!-- address map js -->
    @yield('address-map-js')
    <!-- filter amount js -->
    @yield('filter-amount-js')
    <!-- cart js -->
    @yield('cart-js')
</body>

</html>