<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Sign Up | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('auth/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/style-green.css') }}?ver={{ date('his') }}">
</head>

<body class="page-ath theme-modern page-ath-modern page-ath-alt">

    <div class="page-ath-wrap">
        <div class="page-ath-content">

            <center>
                <div class="page-ath-header"><a href="/" class="page-ath-logo"
                        style="font-weight:bold; font-size: 30px"><img class="page-ath-logo-img"
                            src="{{ asset('auth/images/logo.png') }}" alt="Logo" style="height: 50px"></a></div>
            </center>


            <div class="page-ath-form" style="width: 600px">

                <h2 class="page-ath-heading">
                    <center>Sign Up <small>Create Your {{ env('APP_NAME') }} Account
                        </small></center>
                </h2>

                @if ($errors->any())

                    <div class="alert alert-danger" class="close" data-dismiss="alert" aria-label="close">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif

                <form class="register-form validate validate-modern" method="POST" action="{{ route('register') }}"
                    id="register">
                    @csrf

                    <input type="hidden" name="referral_code" value="" />

                    <div class="input-item">
                        <input type="text" placeholder="Your First Name" class="input-bordered" name="first_name"
                            value="{{ old('first_name') }}" minlength="3" data-msg-required="Required."
                            data-msg-minlength="At least 3 chars." required>
                    </div>
                    <div class="input-item">
                        <input type="text" placeholder="Your Last Name" class="input-bordered" name="last_name"
                            value="{{ old('last_name') }}" minlength="3" data-msg-required="Required."
                            data-msg-minlength="At least 3 chars." required>
                    </div>
                    <div class="input-item">
                        <input type="email" placeholder="Your Email" class="input-bordered" name="email"
                            value="{{ old('email') }}" data-msg-required="Required."
                            data-msg-email="Enter valid email." required>
                    </div>
                    <div class="input-item">
                        <input type="password" placeholder="Password" class="input-bordered" name="password"
                            id="password" minlength="6" data-msg-required="Required."
                            data-msg-minlength="At least 6 chars." required>
                    </div>
                    <div class="input-item">
                        <input type="password" placeholder="Repeat Password" class="input-bordered"
                            name="password_confirmation" data-rule-equalTo="#password" minlength="6"
                            data-msg-required="Required." data-msg-equalTo="Enter the same value."
                            data-msg-minlength="At least 6 chars." required>
                    </div>

                    <div class="input-item text-left">
                        <input name="terms" class="input-checkbox input-checkbox-md" id="agree" type="checkbox"
                            required="required" data-msg-required="You should accept our terms and policy.">
                        <label for="agree">I agree to the <a target="_blank"
                                href="#">Terms and
                                Condition</a> and
                            <a target="_blank" href="#">Privacy and
                                Policy</a>.</label>
                    </div>

                    {{-- <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div> --}}
                    @if ($errors->has('token'))
                        <span class="text-danger">{{ $errors->first('token') }}</span>
                    @endif
                    <button class="btn btn-primary btn-block">Create Account</button>
                </form>


                <div class="gaps-4x"></div>
                <div class="form-note">
                    Already have an account ? <a href="/login"> <strong>Sign in
                            instead</strong></a>
                </div>
            </div>


            <div class="page-ath-footer">
                <ul class="socials mb-3">
                    <li><a href="#" title="Facebook"><em class="fab fa-facebook-f"></em></a></li>
                    <li><a href="#" title="Twitter"><em class="fab fa-twitter"></em></a></li>
                    <li><a href="#" title="Telegram"><em class="fab fa-telegram"></em></a></li>
                    <li><a href="#" title="Instagram"><em class="fab fa-instagram"></em></a></li>
                    <li><a href="#" title="LinkedIn"><em class="fab fa-linkedin"></em></a></li>
                </ul>
                <ul class="footer-links guttar-20px align-items-center">
                    <li><a href="#">Privacy and Policy</a></li>
                    <li><a href="#">Terms and Condition</a></li>
                </ul>
                <div class="copyright-text">&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All Right Reserved.
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('auth/js/jquery.bundle.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('auth/js/script.js') }}?ver={{ date('his') }}"></script>

    <script type="text/javascript">
        jQuery(function() {
            var $frv = jQuery('.validate');
            if ($frv.length > 0) {
                $frv.validate({
                    errorClass: "input-bordered-error error"
                });
            }
        });



    </script>


</body>

</html>
