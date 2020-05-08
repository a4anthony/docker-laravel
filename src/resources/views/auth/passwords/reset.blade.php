@extends('store.layouts.melamart')

@section('title')
<title>Reset Password | MelaMart</title>
@endsection

@section('password_reset')
<style>
    .header-area {
        display: none !important;
    }

    .footer-area {
        display: none !important;
    }
</style>
<!-- checkout-area start -->
<div class="account-area ptb-100">
    <div class="container">
        <div class="row" style="height: 80vh;">
            <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3  col-12 my-auto">
                <div class="text-center" style="margin: 2rem;">
                    <a href="/">
                        <img src="{{asset('images/logo-45.png')}}" alt="" class="img-fluid">
                    </a>
                </div>
                <div class="col-style b-shadow">
                    <form method="POST" action="/{{$token}}">
                        @csrf
                        <input type="text" name="token" value="{{$token}}" hidden>
                        <div class="account-form form-style">

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p>New Password </p>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p>Confirm New Password</p>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                    </div>
                                </div>

                            </div>

                            <button>Save Changes</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection