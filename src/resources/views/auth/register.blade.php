@extends('store.layouts.melamart')
@section('title')
<title>Register | MelaMart</title>
@endsection
@section('registerpage')
<!-- .breadcumb-area start -->
<div class="breadcumb-area  ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Account</h2>
                    <ul>
                        <li><span>Register</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- register-area start -->
<div class="account-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                <div class="account-form form-style">
                    <form method="POST" action="{{ route('register') }}" class="b-shadow">
                        @csrf

                        <?php
                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                        $token = substr(str_shuffle($permitted_chars), 0, 50);
                        ?>
                        <input name="token" hidden value="{{$token}}">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p>First Name</p>
                                    <input id="firstname" type="text" class=" @error('name') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="lastname" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p>Last Name</p>
                                    <input id="lastname" type="text" class=" @error('name') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p>Email Address</p>
                                    <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p>Phone Number</p>

                                    <input id="name" type="tel" maxlength="11" class=" @error('phone') is-invalid @enderror" name="phone" required autocomplete="phone" autofocus>
                                    <small>Format: 08012345678</small>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p>Password</p>
                                    <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p>Confirm Password</p>
                                    <input id="password-confirm" type="password" class="" name="password_confirmation" required autocomplete="new-password">

                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit">Register</button>
                                <div class="text-center">
                                    <a href="login">Or Login</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- register-area end -->
@endsection