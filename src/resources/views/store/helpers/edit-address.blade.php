<div class="row">
    <!-- latitude and logitude start -->
    <div class="form-group">
        <input hidden name="address_latitude" value="{{ old('address_latitude',$address->address_latitude) }}" id="address-latitude" class="@error('address_latitude') is-invalid @enderror" />
    </div>
    <input hidden name="address_longitude" value="{{ old('address_longitude',$address->address_longitude) }}" id="address-longitude" />
    <!-- latitude and logitude end -->

    <input type="number" name="user_id" hidden value="{{ Auth::user()->id }}">
    <input type="text" name="prev_url" hidden value="{{ $redirectUrl }}">



    <div class="col-lg-6 col-sm-6">
        <div class="form-group">
            <p>First Name</p>
            <input name="firstname" value="{{ old('firstname', $address->first_name) }}" class="@error('firstname') is-invalid @enderror" type="text" placeholder="First Name">
            @error('firstname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="form-group">
            <p>Last Name</p>
            <input name="lastname" value="{{ old('lastname', $address->last_name) }}" class="@error('lastname') is-invalid @enderror" type="text" placeholder="Last Name">
            @error('lastname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="form-group">
            <p>Phone</p>
            <input type="tel" value="{{ old('phone', $address->phone) }}" class="@error('phone') is-invalid @enderror" name="phone" placeholder="Phone Number">
            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="col-lg-6 col-sm-6">
        <div class="form-group">
            <p>Home/Apartment Number <span style="font-size: .7rem;">(optional)</span></p>
            <input type="text" value="{{ old('address_number', $address->address_number) }}" name="address_number" placeholder="Enter your home/apartment number">
        </div>
    </div>


    <div class="col-lg-12">
        <div class="form-group">

            <p>Street Address</p>
            <input id="address_address" placeholder="Enter a delivery address" class="map-input @error('address_address') is-invalid @enderror @error('address_latitude') is-invalid @enderror" name="address_address" value="{{ old('address_address', $address->address_address) }}" type="text" autocomplete="off" readonly>

            <div id="address-map-container" style="width:100%;height:500px;" class="d-none">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>

            <span id="address-invalid" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #e3342f;"></span>


            @error('address_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            @error('address_latitude')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <p>Additional Information <span style="font-size: .7rem;">(optional)</span></p>
            <input id="address_additional" placeholder="Directions, landmark" value="{{ old('address_additional', $address->address_additional) }}" name="address_additional" type="text">
        </div>
    </div>

</div>

<button id="add-address-btn">SAVE CHANGES</button>

<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&libraries=geometry,places"></script>

@section('address-map-js')
<script src="{{asset('js/map.js')}}?<?php echo date('map.js'); ?>"></script>
@endsection



















































