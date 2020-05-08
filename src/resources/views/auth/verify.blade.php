@extends('store.layouts.melamart')

@section('title')
<title>Verification confirmation</title>
@endsection
@section('meta')
<!-- redirects user to homepage -->
<meta http-equiv="refresh" content="7;url=/">
@endsection


@section('email_verified')
<style>
    .header-area {
        display: none !important;
    }

    .footer-area {
        display: none !important;
    }
</style>
<div class="container">
    <div class="row justify-content-center " style="height: 80vh;">
        <div class="col-md-8 col-12 my-auto">
            <div class="text-center" style="margin: 2rem;">
                <a href="/">
                    <img src="{{asset('images/logo-45.png')}}" alt="" class="img-fluid">
                </a>
            </div>
            <div class="col-style b-shadow">
                <h5>{{ __('Congratulaions!') }}</h5>

                <p>You have successfully verified your email address</p>

                <div style="margin-top: 1rem;">
                    <span id="timer">
                        You will be redirected to our homepage in <span id="time" style="color: blue;">5</span> seconds<br>
                    </span>

                </div>
                <span>
                    or click <a href="/">here</a> to go to homepage

                </span>
            </div>
        </div>
    </div>
</div>

<!-- countdown and redirect to  home page -->
@section('redirect-js')
<script type="text/javascript">
    $(document).ready(function() {
        var counter = 5;
        var interval = setInterval(function() {
            counter--;
            // Display 'counter' wherever you want to display it.
            if (counter <= 0) {
                clearInterval(interval);
                $('#timer').html("redirecting...");
                return;
            } else {
                $('#time').text(counter);
            }
        }, 1000);
    });
</script>
@endsection
@endsection