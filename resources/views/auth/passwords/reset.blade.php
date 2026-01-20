<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env("APP_NAME") }}">
    <meta name="author" content="{{ env("APP_DEVELOPER") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>New Password Selection | {{ env("APP_NAME") }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver=20241116180">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}?ver=20241116180">

    <style>
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
            margin: 150px 200px 150px 200px;
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
                margin: 30px 0px 350px 0px;
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

        .password-toggle .toggle-password-2 {
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
                    <img class="page-ath-logo-img" src="images/logo.png" alt="Benue Links Logo" style="max-height: 80px">
                </a>
            </div>



            <div class="page-ath-form">
                <h2 class=""><small><strong>Create New Password!</strong></small></h2>
                <span style="font-size: 14px">Select a new password for your {{ env('APP_NAME') }}
                    account</span>


                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Password and Password Confirmation do not match</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="mt-4 text-center">
                    <form class="login-form validate validate-modern" method="POST"
                        action="{{ route('createNewPassword') }}" id="register">
                        @csrf

                        <div class="input-item password-toggle">
                            <input type="password" placeholder="Password" class="input-bordered" name="password"
                                id="password" minlength="6" data-msg-required="Required."
                                data-msg-minlength="At least 6 chars." required>
                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>

                        <div class="input-item password-toggle">
                            <input type="password" placeholder="Confirm Password" class="input-bordered"
                                name="password_confirmation" id="password2" minlength="6" data-msg-required="Required."
                                data-msg-minlength="At least 6 chars." required>

                            <span class="toggle-password-2" onclick="togglePassword2Visibility()">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>

                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="btn btn-success btn-block">Create New Password</button>
                    </form>
                </div>


                <div class="gaps-4x"></div>
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

        function togglePassword2Visibility() {
            var passwordInput = document.getElementById("password2");
            var icon = document.querySelector(".toggle-password-2 i");

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
