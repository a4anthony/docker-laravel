@extends('store.Profile.index')

@section('title')
<title>Edit Address | MelaMart</title>
@endsection

@section('address_edit')
<div class=" d-sm-none">
    <hr class="divider visibility-none">
</div>
<!-- checkout-area start -->
<div class="account-area ptb-100 b-shadow background background-sm div-padding">
    <div class="container">
        <!-- tab title start -->
        <div class="row  {{ request()->is('account/address-book/add*') ? 'top-pad' : ''}}">
            <div class="col-lg-1 col-md-1  col-sm-1 col-1 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <a href="/account/address-book" style="font-size: 2rem; color: #333;">
                    <span class="iconify" data-icon="bx:bx-arrow-back" data-inline="false"></span>
                </a>
            </div>
            <div class="col-lg-4 col-md-4  col-sm-4 col-6 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5 class="no-margin">Edit Address</h5>
            </div>
        </div>
        <!-- tab title end-->
        <!-- edit address form start -->
        <div class="row top-pad">
            <div class="col-lg-12  col-md-12 col-12">
                <form method="POST" action="/account/edit/address">
                    @csrf
                    @method('PUT')
                    <div class="account-form form-style">
                        @include('store.helpers.edit-address')
                    </div>
                </form>
            </div>
        </div>
        <!-- edit address form end -->
    </div>
</div>
<!-- checkout-area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection