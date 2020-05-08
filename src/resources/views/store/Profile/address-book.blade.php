@extends('store.Profile.index')

@section('title')
<title>Address Book | MelaMart</title>
@endsection

@section('address_book')
<div class=" d-sm-none">
    <hr class="divider visibility-none">
</div>
<!-- cart-area start -->
<div class="cart-area ptb-100 background b-shadow no-shadow profile-tab">
    <div class="container">
        <div class="row  {{ request()->is('account/address-book') ? 'top-pad' : ''}}">
            <!-- tab header start -->
            <div class="col-lg-6 col-md-6  col-sm-6 col-6 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}} ">
                <h5>Address Book</h5>
            </div>
            <!-- tab header end -->
            <!-- add address area start -->
            <div class="col-lg-6 col-md-6  col-sm-6 col-6 offset-sm-0 offset-md-0 offset-lg-0 text-center {{ request()->is('account/*') ? 'offset-6' : ''}}">
                <a href="/account/address-book/add" class="btn mela-btn floatright">
                    Add Address
                </a>
            </div>
            <!-- add address area end -->
        </div>
        @if (count($arrayAddresses) != 0)
        <div class="no-padding paginate-results">
            <p>Showing {{ $arrayAddresses->firstItem() }} to {{ $arrayAddresses->lastItem() }} of {{$arrayAddresses->total()}}
                addresses
            </p>
        </div>
        @endif
        <div class="row">
            @if (count($arrayAddresses) != 0)
            @foreach($arrayAddresses as $address)
            @php
            $key = $loop->iteration;
            @endphp
            <!-- address content start -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 m-bottom">
                <div class="content fix-address-height div-padding">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 my-auto-sm ">
                                <p class="address-name">{{ $address->first_name }} {{ $address->last_name }}</p>
                                <p class="phone">{{ $address->phone}}</p>
                                <p>{{$address->address_number}}</p>
                                <p>{{$address->address_address}}</p>
                                <p>{{$address->address_additional}}</p>
                                <p>Akwa Ibom State, Nigeria.</p>
                            </div>
                            <!-- address action start -->
                            <div class="action-btn address">
                                <div class="text-center featured-product-content">
                                    <ul>
                                        <li>
                                            <a href="/account/address-book/edit/{{$address->address_id}}"><i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" onclick="event.preventDefault();
                                         document.getElementById('delAddress{{$address->address_id}}').submit();"><i class="fa fa-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <form id="delAddress{{$address->address_id}}" action="/account/address-book/delete" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="number" name="address_id" hidden value="{{$address->address_id}}">
                                </form>
                            </div>
                            <!-- address action end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- address content end -->
            @endforeach
            @else
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 empty">
                <h6>Oops! no delivery address has been added yet.</h6>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- cart-area end -->
<!-- pagination area start -->
<nav class="blog-pagination justify-content-center d-flex ">
    <ul class="pagination d-block d-sm-none">
        {{ $arrayAddresses->appends(Request::except('page'))->links('store.vendor.pagination.bootstrap-sm')  }}
    </ul>
    <ul class="pagination d-none d-md-block">
        {{ $arrayAddresses->appends(Request::except('page'))->links()  }}
    </ul>
</nav>
<!-- pagination area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection