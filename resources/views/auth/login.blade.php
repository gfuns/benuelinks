<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="Xtratech Global Solution">
    <meta name="author" content="Xtratech Global Solution">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Sign In | Peace Mass Transit</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver=20241116180">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}?ver=20241116180">

    <style type="text/css">
        .guest-prompt {
            background: #F6F7F9;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
        }

        .guest-btn {
            background-color: #fd7e14;
            color: white;
            border-radius: 30px;
            /* font-size: 12px; */
        }

        .guest-btn:hover {
            background-color: #FF7302;
            color: white;
        }



        .customPageContent {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            margin: 50px 200px 20px 200px;
            padding: 20px;
            width: 500px;
        }

        .page-ath-form,
        .page-ath-header,
        .page-ath-footer,
        .page-ath-text {
            margin-left: 5px;
            margin-right: 5px;
            padding: 0 10px
        }

        @media (max-width: 575px) {
            .customPageContent {
                background: #fff;
                border: none;
                border-radius: 0px;
                margin: 30px 0px 0px 0px;
                padding: 0px
            }

            .page-ath-form {
                margin: 30px 0px 150px 0px;
            }

            .page-ath-form,
            .page-ath-header,
            .page-ath-footer,
            .page-ath-text {
                margin-left: auto;
                margin-right: auto;
                padding: 0 30px
            }
        }


        .password-toggle {
            position: relative;
        }

        .password-toggle input[type="password"] {
            padding-right: 30px;
        }

        .password-toggle .toggle-password {
            position: absolute;
            top: 37%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>

</head>

<body class="page-ath theme-modern page-ath-modern">

    <div class="page-ath-wrap flex-row-reverse">
        <div class="page-ath-content customPageContent">
            <div class="page-ath-header">
                <a href="/" class="page-ath-logo">
                    <img class="page-ath-logo-img" src="{{ asset("images/logo.png") }}" alt="Peace Mass Transit Logo">
                </a>
            </div>



            <div class="page-ath-form">
                <h2 class=""><small><strong>Sign Into Your PMT Account!</strong></small></h2>


                @if ($errors->any())
                    <div class="alert alert-dismissible fade show alert-danger"><a href="javascript:void(0)"
                            class="close" data-dismiss="alert" aria-label="close" style="color:white">&nbsp;</a>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="login-form validate validate-modern" method="POST" action="{{ route('login') }}"
                    id="register">
                    @csrf

                    <div class="mb-4 guest-prompt">
                        <div class="row">
                            <div class="col-9" class="text-muted"> Don't want to create an account now? No worries, you
                                can ontinue as a guest</div>
                            <div class="col-3"> <img src="images/onboarding.png" /></div>
                        </div>
                        @if (Session::has('guestBookingID'))
                            <a href="{{ route('guest.passengerDetails', [Session::get('guestBookingID')]) }}"
                                class="btn btn-sm rounded-pill px-4 guest-btn">Continue as Guest</a>
                        @else
                            <a href="/" class="btn btn-sm rounded-pill px-4 guest-btn">Continue as Guest</a>
                        @endif

                    </div>

                    <div class="mb-4 text-center">
                        ----------------------------------- OR ----------------------------------------
                    </div>

                    <div class="input-item">
                        <input type="email" placeholder="Your Email" class="input-bordered" name="email"
                            value="{{ old('email') }}" data-msg-required="Required."
                            data-msg-email="Enter valid email." required>
                    </div>
                    <div class="input-item password-toggle">
                        <input type="password" placeholder="Password" class="input-bordered" name="password"
                            id="password" minlength="6" data-msg-required="Required."
                            data-msg-minlength="At least 6 chars." required>
                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                <i class="fa fa-eye"></i>
                            </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-item text-left">
                            <input class="input-checkbox input-checkbox-md" type="checkbox" name="remember"
                                id="remember-me">
                            <label for="remember-me">Remember Me</label>
                        </div>
                        <div>
                            <a href="/password/reset">Forgot password?</a>
                            <div class="gaps-2x"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>


                <div class="gaps-4x"></div>
                <div class="form-note">
                    Don't have an account ? <a href="/register"> <strong>Sign Up Now</strong></a>
                </div>
                <div class="mb-2">&nbsp;</div>
            </div>

        </div>
        <div class="page-ath-gfx" style="background-image: url(images/ath-gfx.png); no-repeat; background-size:cover; ">
            <div class="w-100 d-flex justify-content-center">
                <div class="col-md-8 col-xl-5">

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver=20241116180"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver=20241116180"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        jQuery(function() {
            var $frv = jQuery('.validate');
            if ($frv.length > 0) {
                $frv.validate({
                    errorClass: "input-bordered-error error"
                });
            }
        });

        function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var icon = document.querySelector(".toggle-password i");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
    </script>

</body>

</html>
