@extends('store.layouts.melamart')
@section('title')
<title>Reset Password | MelaMart</title>
@endsection
@section('password_reset')
<!-- .breadcumb-area start -->
<div class="breadcumb-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Account</h2>
                    <ul>
                        <li><span>Password Reset</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- checkout-area start -->
<div class="account-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">

                <div style="min-height: 40px;">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>


                <form method="POST" action="/reset/password" class="b-shadow">
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



                        <button type="submit">Send Password Reset Link</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- checkout-area end -->
@endsection