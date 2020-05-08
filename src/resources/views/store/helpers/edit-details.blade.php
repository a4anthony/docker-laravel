<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <p>First Name </p>
            <input id="firstname" type="text" class="@error('email') is-invalid @enderror" name="firstname" value="{{ Auth::user()->firstname }}" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <p>Last Name </p>
            <input id="lastname" type="text" class="@error('email') is-invalid @enderror" name="lastname" value="{{ Auth::user()->lastname }}" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <p>Email Address
                @if ( Auth::user()->email_verified_at == null)
                <span style="float: right;"><a href="/verifyemail" style="color: red; text-decoration: underline;"> verify email</a></span>
                @endif
            </p>
            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" disabled autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <p>Phone Number </p>
            <input id="number" type="tel" class="@error('phone') is-invalid @enderror" maxlength="11" minlength="11" name="phone" value="{{ Auth::user()->phone }}" autofocus>

            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>

<button>Save Changes</button>