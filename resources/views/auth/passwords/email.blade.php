<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Reset Password | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('auth/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/style-green.css') }}?ver={{ date('his') }}">
</head>

<body class="page-ath theme-modern page-ath-modern page-ath-alt">

    <div class="page-ath-wrap">
        <div class="page-ath-content">

            <center>
                <div class="page-ath-header"><a href="/" class="page-ath-logo"
                        style="font-weight:bold; font-size: 30px"><img class="page-ath-logo-img"
                            src="{{ asset('auth/images/logo.png') }}" alt="Logo" style="height: 50px">
                    </a></div>
            </center>

            <div class="page-ath-form" style="width: 500px">

                <h2 class="page-ath-heading">Reset Password <span>If you forgot your password, well, then we'll
                        email you instructions to reset your password.</span></h2>
                @if (Session::has('error'))
                    <div class="alert alert-warning">{{Session::get('error')}}</div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success">Password reset mail sent successfully. Please check your mail inbox.</div>
                @endif
                <form method="POST" action="{{ route('password.forgot') }}"
                    class="forgot-pass-form validate validate-modern">
                    @csrf
                    <div class="input-item">
                        <input type="email" placeholder="Your Email Address" name="email" value=""
                            class="input-bordered" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                        </div>
                        <div>
                            <a href="/login">Return to login</a>
                        </div>
                    </div>
                    <div class="gaps-0-5x"></div>
                </form>

            </div>

            <div class="page-ath-footer">
                <ul class="socials mb-3">
                    <li><a href="#" title="Facebook"><em
                        class="fab fa-facebook-f"></em></a></li>
            <li><a href="#" title="Twitter"><em
                        class="fab fa-twitter"></em></a></li>
            <li><a href="#" title="Telegram"><em
                            class="fab fa-telegram"></em></a></li>
            <li><a href="#" title="Instagram"><em
                        class="fab fa-instagram"></em></a></li>
            <li><a href="#" title="LinkedIn"><em
                        class="fab fa-linkedin"></em></a>
            </li>
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
