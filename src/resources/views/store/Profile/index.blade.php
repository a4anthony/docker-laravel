@extends('store.layouts.melamart')

@section('profilepage')
<!-- .breadcumb-area start -->
<div class="ptb-100 {{ request()->is('account') ? 'full-height' : ''}}">
    <div class="container">
        <!-- page header small screen start -->
        <div class="back-btn {{ request()->is('account') ? 'hide-nav' : ''}} b-shadow d-sm-none">
            @if (isset($_GET['reference']))
            <a href="/account/orders">
                <span class="iconify" data-icon="bx:bx-arrow-back" data-inline="false"></span>
            </a>
            @elseif (request()->is('account/address-book/*'))
            <a href="/account/address-book">
                <span class="iconify" data-icon="bx:bx-arrow-back" data-inline="false"></span>
            </a>
            @else
            <a href="/account">
                <span class="iconify" data-icon="bx:bx-arrow-back" data-inline="false"></span>
            </a>
            @endif
            <span class="page-title">
                @if ((request()->is('account/orders')) && (!isset($_GET['reference'])))
                Orders
                @endif
                @if (isset($_GET['reference']))
                Orders
                @endif
                @if (request()->is('account/wishlist*'))
                Wishlist
                @endif
                @if (request()->is('account/address-book'))
                Address Book
                @endif
                @if (request()->is('account/address-book/edit*'))
                Edit Address
                @endif
                @if (request()->is('account/address-book/add*'))
                Add Address
                @endif
                @if (request()->is('account/edit/details*'))
                Edit Personal Details
                @endif
                @if (request()->is('account/update/password*'))
                Change Password
                @endif
            </span>
        </div>
        <!-- page header small screen end -->
        <div class="row">
            <!-- welcome tab small screen start -->
            <div class="col-12 {{ request()->is('account/*') ? 'hide-nav' : ''}} d-sm-none">
                <div class="welcome b-shadow">
                    <h6>Welcome {{ Auth::user()->firstname }},</h6>
                    <p>{{ Auth::user()->email }}
                        <!-- checks if user email is verified -->
                        @if ( Auth::user()->email_verified_at == null)
                        <span><a href="/verifyemail"> verify email</a></span>
                        @endif
                    </p>
                    <p>{{ Auth::user()->phone }}</p>
                    <p><span><i class="fas fa-sun"></i></span> MelaPoints: 25</p>
                </div>
            </div>
            <!-- welcome tab small screen end -->
            <!-- side menu tab start -->
            <div class="col-lg-3 col-md-2 col-sm-3  col-12 {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <div class="profile-menu background background-sm b-shadow">
                    <ul class="menu-btn">
                        <li id="link1" class="{{ (request()->is('account')) ? 'active-tab' : '' }} {{ request()->is('account') ? 'hide-nav' : ''}}"><a href="/account">
                                <span class="iconify" data-icon="et:profile-male" data-inline="false"></span>
                                <span class="menu-text">Dashboard</span></a>
                        </li>
                        <li id="link2" class="{{ (request()->is('account/orders*')) ? 'active-tab' : '' }}"><a href="/account/orders">
                                <span class="iconify" data-icon="cil:basket" data-inline="false"></span>
                                <span class="menu-text">Orders</span>
                            </a></li>
                        <li id="link3" class="{{ (request()->is('account/wishlist')) ? 'active-tab' : '' }}"><a href="/account/wishlist">
                                <span class="iconify" data-icon="bytesize:heart" data-inline="false"></span>
                                <span class="menu-text">Wishlist</span></a>
                        </li>
                        <li id="link4" class="{{ (request()->is('account/address-book*')) ? 'active-tab' : '' }}"><a href="/account/address-book">
                                <span class="iconify" data-icon="foundation:address-book" data-inline="false"></span>
                                <span class="menu-text">Address Book</span></a>
                        </li>
                        <li id="link5" class="{{ (request()->is('account/edit*')) ? 'active-tab' : '' }} d-sm-none"><a href="/account/edit/details">
                                <span class="iconify" data-icon="ant-design:edit-outlined" data-inline="false"></span>
                                <span class="menu-text">Edit Details</span></a>
                        </li>
                        <li id="link6" class="{{ (request()->is('account/update*')) ? 'active-tab' : '' }}"><a href="/account/update/password">
                                <span class="iconify" data-icon="cil:settings" data-inline="false"></span>
                                <span class="menu-text">Change Password</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- side menu tab end -->
            <!-- logout start -->
            <div class="col-12 text-center {{ request()->is('account/*') ? 'hide-nav' : ''}} d-sm-none">
                <hr class="divider visibility-none">
                <hr class="divider visibility-none">
                <a href="/account/address-book/add" class="btn mela-btn">
                    Logout
                </a>
            </div>
            <!-- logout end -->
            <!-- adds white space -->
            <div class="col-12 d-sm-none ">
                <hr class="divider visibility-none">
            </div>
            <!-- profile content start -->
            <div class="col-lg-9 col-md-10 col-sm-12 col-12 no-margin no-padding">
                <!-- dashboard-area start -->
                @yield('dashboard')
                <!-- profilepage-area end -->
                <!-- orders-area start -->
                @yield('orders')
                <!-- orders-area end -->
                <!-- wishlist-area start -->
                @yield('wishlist')
                <!-- wishlist-area end -->
                <!-- addressbook-area start -->
                @yield('address_book')
                <!-- addressbook-area end -->
                <!-- edit-details-area start -->
                @yield('edit_details')
                <!-- edit-details-area end -->
                <!-- change-password-area start -->
                @yield('change_password')
                <!-- change-password-area end -->
                <!-- address-edit-area start -->
                @yield('address_edit')
                <!-- address-edit-area end -->
                <!-- address-add-area start -->
                @yield('address_add')
                <!-- address-add-area end -->
            </div>
            <!-- profile content end -->
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- featured-product-area start -->
            @include('store.helpers.featured')
            <!-- featured-product-area end -->
        </div>
    </div>
</div>
@endsection