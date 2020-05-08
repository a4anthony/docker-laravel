@extends('store.Profile.index')

@section('title')
<title>Change Password | MelaMart</title>
@endsection

@section('change_password')
<div class=" d-sm-none">
    <hr class="divider visibility-none">
</div>
<!-- checkout-area start -->
<div class="account-area ptb-100 background background-sm b-shadow no-shadow b-shadow-sm ">
    <div class="container">
        <div class="row">
            <div class="col-12 my-auto {{ request()->is('account/*') ? 'hide-nav' : ''}}">
                <h5>Change Password</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <form method="POST" action="/update/password">
                    @csrf
                    @method('PUT')
                    <div class="account-form form-style">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p>Old Password </p>
                                    <input id="password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" value="{{ old('old_password') }}" required autocomplete="">

                                    @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <p>New Password </p>
                                    <input id="new_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
<!-- checkout-area end -->
<hr class="divider visibility-none">
<hr class="divider visibility-none">
@endsection