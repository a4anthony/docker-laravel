@extends('store.layouts.melamart')

@section('title')
<title>Checkout | MelaMart</title>
@endsection
@section('scripts')
<script>
    var addressArray = <?php echo json_encode($address_id); ?>; //converts user address id to JSON
</script>
@endsection

@section('checkoutpage')
<!-- checkout-area start -->
<div class="checkout-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-7">
                <h3 class="col-header">Delivery Details</h3>
                <div class="checkout-form form-style col-style b-shadow">
                    <div class="row">
                        <!-- address dropdown -->
                        <div class="col-sm-12 col-lg-12 col-12">
                            <p>Select Address *</p>
                            <select id="address_select">
                                <option id="" value="">-- Select Delivery Address --</option>
                                @foreach ($array_addresses as $address)
                                <option id="address_option{{$address->address_id}}" value="{{$address->address_id}}">{{$address->address_address}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <div class="display_address d-none">
                                <!-- address preview -->
                                <div id="display_address_div">
                                    <h6>Selected Address:</h6>
                                    <p>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
                                    <p>{{ Auth::user()->phone }}</p>
                                    <p id="address"></p>
                                    <p id="landmark"></p>
                                    <p id="state_country"></p>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <p id="edit_btn" class="edit_address"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12">

                        </div>
                    </div>

                    <h6>Add Delivery Address</h6>
                    <form method="POST" action="/account/add/address">
                        @csrf

                        <div class="account-form form-style">
                            @include('store.helpers.add-address')
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-12 d-md-none">
                <hr class="divider visibility-none">
            </div>
            <div class="col-lg-4 col-sm-5">
                <h3 class="col-header">Your Order</h3>
                <div class="order-area col-style b-shadow">
                    <ul class="total-cost">
                        @foreach ($invoices as $invoice)
                        <li>{{$invoice->product->title}} <br>({{$invoice->quantity}} units)<span class="pull-right"><span> &#8358;</span><?php echo (number_format($invoice->total(auth()->id()))); ?></span></li>
                        <hr class="divider">
                        @endforeach
                        <li>Subtotal <span class="pull-right"><strong><span> &#8358;</span><?php echo (number_format($invoice->total(auth()->id()))); ?></strong></span></li>
                        <hr class="divider visibility-none">
                        <li>Shipping <span class="pull-right">Free</span></li>
                        <hr class="divider visibility-none">
                        <li>Total<span class="pull-right"><span> &#8358;</span><?php echo (number_format($invoice->total(auth()->id()))); ?></span></li>
                    </ul>

                    <!-- Paystack Form Start -->
                    <form id="paystack_form" method="POST" action="/pay">
                        @csrf
                        <input id="delivery_address_id" type="hidden" name="address_id" value="">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="first_name" value="{{ Auth::user()->firstname }}">
                        <input type="hidden" name="last_name" value="{{ Auth::user()->lastname }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                        @php
                        $total_amount = 1200;
                        @endphp
                        @foreach ($invoices as $invoice)
                        @php
                        $titleArray[] = $invoice->product->title . ' (' . $invoice->quantity . ')';
                        @endphp

                        @endforeach
                        @php
                        $title = implode(', ', $titleArray);
                        @endphp
                        <input type="hidden" name="cart_items" value="{{ $title}}">
                        <input type="hidden" name="invoice_id" value="{{ $invoice->invoice_id}}">

                        <input type="hidden" name="amount" value="{{$invoice->total(auth()->id())}}">

                        <span id="payment_error" class="text-danger"></span>
                        <span id="payment_error_null" class="text-danger"></span>

                        @if(Auth::user()->email_verified_at != null)
                        <button id="pay" class="btn btn-bg btn-chk" onclick="event.preventDefault();" type="submit"> Place Order</button>
                        @else
                        <button id="pay_null" class="btn btn-bg btn-chk" onclick="event.preventDefault();" type="submit"> Place Order</button>
                        @endif

                    </form>
                    <!-- Paystack Form End -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- checkout-area end -->
<!-- address-form-js start -->
@section('checkout-address-js')
<script src="{{ mix('/js/checkout.js') }}" defer></script>
@endsection
<!-- address-form-js end -->

@endsection