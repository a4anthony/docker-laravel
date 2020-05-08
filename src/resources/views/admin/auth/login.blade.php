@extends('admin.layouts.app')
@section('title')
<title>Login</title>
@endsection
@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-6 col-md-6" style="margin-top: 10vh;">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">

                                <div class="text-center">
                                    <img src="{{asset('admin/img/logo_sq.png')}}" style="width: 2rem;" alt="">

                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>

                                </div>
                                <form method="POST" action="{{ route('loginSubmit') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror </div>
                                    <div style="max-height: 40px; min-height: 40px;">
                                        @if (session('error'))
                                        <div class="alert alert-danger" style="padding: .2rem; border: none; background: none;" role="alert">
                                            * {{ session('error') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">

                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                    <hr>

                                </form>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="register.html">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection