@extends('store.Profile.index')

@section('title')
<title>Account | MelaMart</title>
@endsection

@section('dashboard')
<div class=" d-sm-none">
    <hr class="divider visibility-none">
</div>
<!-- cart-area start -->
<div class="cart-area ptb-100 background background-sm b-shadow no-shadow b-shadow-sm div-padding">
    <div class="container">
        <!-- page title start -->
        <div class="row">
            <div class="col-12 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5>Account Information</h5>
            </div>
        </div>
        <!-- page title end -->
        <!-- edit deatails form start -->
        <div class="row">
            <div class="col-lg-12  col-md-12 col-12">
                <form method="POST" action="/edit/details">
                <p></p>
                    @csrf
                    @method('PUT')
                    <div class="account-form form-style">
                        @include('store.helpers.edit-details')
                    </div>
                </form>
            </div>
        </div>
        <!-- edit deatails form end -->
    </div>
</div>
<!-- cart-area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection