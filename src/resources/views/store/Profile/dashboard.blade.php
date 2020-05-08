@extends('store.Profile.index')

@section('title')
<title>Account | MelaMart</title>
@endsection

@section('dashboard')
<!-- cart-area start -->
<div class="cart-area ptb-100 background b-shadow hide-nav">
    <div class="container">
        <div class="row">
            <div class="col-12 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5>Account Information</h5>
            </div>
        </div>
        <hr class="divider visibility-none">
        <div class="row">
            <div class="col-lg-12  col-md-12 col-12">
                <form method="POST" action="/edit/details">
                    @csrf
                    @method('PUT')
                    <div class="account-form form-style">
                        @include('store.helpers.edit-details')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- cart-area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection