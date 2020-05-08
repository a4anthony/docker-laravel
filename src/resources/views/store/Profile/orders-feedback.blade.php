@extends('store.Profile.index')

@section('title')
<title>GiveFeedback on Order | MelaMart</title>
@endsection

@section('edit_details')
<div class=" d-sm-none">
    <hr class="divider visibility-none">
</div>
<!-- checkout-area start -->
<div class="account-area ptb-100 b-shadow background background-sm div-padding">
    <div class="container">
        <!-- tab title start -->
        <div class="row  {{ request()->is('account/address-book/add*') ? 'top-pad' : ''}}">
            <div class="col-lg-1 col-md-1  col-sm-1 col-1 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <a href="/account/orders" style="font-size: 2rem; color: #333;">
                    <span class="iconify" data-icon="bx:bx-arrow-back" data-inline="false"></span>
                </a>
            </div>
            <div class="col-lg-4 col-md-4  col-sm-4 col-6 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5 style="margin:0;">Item Feedback</h5>
            </div>
        </div>
        <!-- tab title end-->
        <div class="row">
            <div class="col-12">
                <form method="POST" action="/feedback/submit">
                    @csrf
                    <input type="number" name="product_id" hidden value="{{$product->id}}">
                    <div class="account-form form-style">
                        <div class="row">
                            <div class="col-lg-2 col-3 no-margin no-padding my-auto">
                                @foreach ($product->images as $key => $image)
                                @if( $key == 0)
                                <img class="images" src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="" class="img-fluid" style="width: 5rem;">
                                @endif
                                @endforeach
                            </div>
                            <div class="col-lg-10 col-9 my-auto">
                                <h5>{{$product->title}}</h5>
                            </div>
                            <div class="col-12" style="visibility: hidden;">
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p>Feedback</p>
                                    <textarea class="@error('feedback') is-invalid @enderror" name="feedback" placeholder="Enter feedback message" id="feedback" cols="150" rows="10"></textarea>
                                    @error('feedback')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button>Give feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- checkout-area end -->
@endsection