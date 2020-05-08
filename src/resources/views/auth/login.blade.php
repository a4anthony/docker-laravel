@extends('store.layouts.melamart')


@section('title')
<title>Login | MelaMart</title>
@endsection


@section('loginpage')
<!-- .breadcumb-area start -->
<div class="breadcumb-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Account</h2>
                    <ul>
                        <li><span>Login</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- checkout-area start -->
<div class="account-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12 account-div">

                <div style="min-height: 40px;">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('login') }}" class="b-shadow">
                    @csrf
                    <div class="account-form form-style">



                        <div class="form-group">
                            <p>Email Address </p>
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Password </p>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="password">Remember me</label>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="/reset/password">Forgot Your Password?</a>
                                </div>
                            </div>
                        </div>


                        <button>SIGN IN</button>
                        <div class="text-center">
                            <a href="/register">Or Create an Account</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- checkout-area end -->
@endsection