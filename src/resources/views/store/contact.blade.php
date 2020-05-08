@extends('store.layouts.melamart')

@section('title')
<title>Contact Us | MelaMart</title>
@endsection

@section('homepage')
@if (session('success'))
<div id="alert-divv">
    <div class="row">
        <div class="col-10">
            <p id="alert-msg">{{ session('success') }}</p>
        </div>
        <div class="col-2">
            <button type="button" id="close-alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif
<!-- contact-area start -->
<div class="contact-area ptb-100">
    <div class="container">
        <h5 class="col-header">Leave a Message</h5>
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="contact-form form-style col-style b-shadow">
                    <div class="cf-msg"></div>
                    <form action="/contact" method="POST" id="cf">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>Name</p>
                                <input type="text" placeholder="Name" value="{{old('name')}}" class="@error('name') is-invalid @enderror" id="fname" name="name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-12  col-sm-6">
                                <p>Email</p>
                                <input type="text" placeholder="Email" value="{{old('email')}}" class="@error('email') is-invalid @enderror " id="email" name="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <p>Subject</p>
                                <input type="text" placeholder="Subject" value="{{old('subject')}}" class="@error('subject') is-invalid @enderror " id="subject" name="subject">
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <p>Message</p>
                                <textarea placeholder="Message" class="contact-textarea @error('message') is-invalid @enderror " id="msg" name="message">{{old('message')}}</textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit">SEND MESSAGE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="contact-wrap col-style b-shadow">
                    <ul>
                        <li>
                            <i class="fa fa-home"></i> Address:
                            <p>Ekit Itam 11 Rd, Uyo, Akwa Ibom State Nigeria</p>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i> Email address:
                            <p>
                                <span>help@melamartonline.com </span>
                            </p>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i> phone number:
                            <p>
                                <span>+(234) 704-576-6325</span>
                                <span>+(234) 802-319-9400</span>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="googleMap" class="b-shadow"></div>
<!-- contact-area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@section('contact-map-js')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&libraries=places"></script>
<script>
    function initialize() {
        const map = new google.maps.Map(document.getElementById('googleMap'), {
            center: {
                lat: 5.051998,
                lng: 7.879780
            },
            zoom: 16
        });
        const marker = new google.maps.Marker({
            map: map,
            position: map.getCenter(),
            animation: google.maps.Animation.BOUNCE,
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection
@endsection