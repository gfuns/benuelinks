<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Sign-In | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">

    <style type="text/css">

        /* Footer styling */
        .footer {
            text-align: center;
            color: #000;
            font-size: 1rem;
            margin-top: 20px;
            padding: 10px 0;
            position: absolute;
            bottom: 10px;
            width: 100%;
            z-index: 2;
        }

        .gfuns {
            font-weight: bold;
            color: black;
        }

        .page-ath-form {
            padding: 35px 40px;
        }

        .jiggy {
            min-width: 410px;
        }

        @media (max-width: 575px) {
            .page-ath-form {
                padding: 25px 30px !important;
            }

            .jiggy {
                min-width: 300px;
            }
        }
    </style>
</head>

<body class="page-ath theme-modern page-ath-modern page-ath-alt">

    <div class="page-ath-wrap">
        <div class="page-ath-content">

            <center>
                <div class="page-ath-header"><a href="/" class="page-ath-logo"
                        style="font-weight:bold; font-size: 30px"><img class="page-ath-logo-img"
                            src="{{ asset('assets/logo.png') }}" alt="Logo" style="height: 50px">
                    </a></div>
            </center>

            <div class="page-ath-form">
                <h2 class="page-ath-heading">
                    <center>Sign In
                        <small class="jiggy">Access Your {{ env('APP_NAME') }} Account</small>
                    </center>
                </h2>
                <form class="login-form validate validate-modern" action="{{ route('login') }}" method="POST">
                    @csrf
                    @if (Session::has('suspended'))
                        <div class="alert alert-dismissible fade show alert-danger" role="alert">
                            <a href="javascript:void(0)" class="close" data-dismiss="alert"
                                aria-label="close">&nbsp;</a>
                            Your account may be inactive or suspended. Please contact us if something is wrong.
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-dismissible fade show alert-danger"><a href="javascript:void(0)"
                                class="close" data-dismiss="alert" aria-label="close">&nbsp;</a> These credentials do
                            not match our records.</div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-dismissible fade show alert-success"><a href="javascript:void(0)"
                                class="close" data-dismiss="alert" aria-label="close">&nbsp;</a>Password Changed
                            Successfully. <br />You can now sign in with your new password</div>
                    @endif

                    <div class="input-item">
                        <input type="email" placeholder="Your Email" data-msg-required="Required."
                            class="input-bordered" name="email" value="" required autofocus>
                    </div>
                    <div class="input-item">
                        <input type="password" placeholder="Password" minlength="6" data-msg-required="Required."
                            data-msg-minlength="At least 6 chars." class="input-bordered" name="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-item text-left">
                            <input class="input-checkbox input-checkbox-md" type="checkbox" name="remember"
                                id="remember-me">
                            <label for="remember-me">Remember Me</label>
                        </div>
                        <div>
                            <a href="#">Forgot password?</a>
                            <div class="gaps-2x"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>

                <div class="gaps-4x"></div>
                <div class="form-note">
                    Don’t have an account? <a href="#"> <strong>Sign up
                            here</strong></a>
                </div>
            </div>


            <div class="page-ath-footer">
                <ul class="socials mb-3">
                    <li><a href="" title="Facebook"><em class="fab fa-facebook-f"></em></a></li>
                    <li><a href="" title="Twitter"><em class="fab fa-twitter"></em></a></li>
                    <li><a href="" title="Telegram"><em class="fab fa-telegram"></em></a></li>
                    <li><a href="" title="Instagram"><em class="fab fa-instagram"></em></a></li>
                    <li><a href="" title="LinkedIn"><em class="fab fa-linkedin"></em></a>
                    </li>
                </ul>
                <ul class="footer-links guttar-20px align-items-center">
                    <li><a href="#" class="">Privacy and Policy</a></li>
                    <li><a href="#" class="">Terms and Condition</a></li>
                </ul>
                <div class="copyright-text gfuns">&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All Right
                    Reserved.
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver={{ date('his') }}"></script>
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
