<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="Xtratech Global Solution">
    <meta name="author" content="Xtratech Global Solution">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Password Reset | Peace Mass Transit</title>
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

            .page-ath-form{
                margin: 30px 0px 200px 0px;
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

        @media (max-width: 420px) {
            .customPageContent {
                background: #fff;
                border: none;
                border-radius: 0px;
                margin: 30px 0px 0px 0px;
                padding: 0px
            }

            .page-ath-form{
                margin: 30px 0px 280px 0px;
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
    </style>

</head>

<body class="page-ath theme-modern page-ath-modern">

    <div class="page-ath-wrap flex-row-reverse">
        <div class="page-ath-content customPageContent">
            <div class="page-ath-header">
                <a href="/" class="page-ath-logo">
                    <img class="page-ath-logo-img" src="{{ asset('images/logo.png') }}" alt="Peace Mass Transit Logo">
                </a>
            </div>



            <div class="page-ath-form">
                <h2 class=""><small><strong>Reset Password!</strong></small></h2>
                <span style="font-size: 14px">If you have forgotten your password, no worries.<br /> We'll
                    email you instructions to reset your password.</span>


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

                <form class="login-form validate validate-modern" method="POST"
                    action="{{ route('initiatePasswordReset') }}" id="register">
                    @csrf

                    <div class="mt-4 text-center">
                        <div class="input-item">
                            <input type="email" placeholder="Your Registered Email" class="input-bordered" name="email"
                                value="{{ old('email') }}" data-msg-required="Required."
                                data-msg-email="Enter valid email." required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>

                </form>

                <div class="gaps-4x"></div>
                <div class="form-note text-center">
                    <a href="/login"><strong> Return To Login Page</strong></a>
                </div>


                <div class="gaps-4x"></div>

                <div class="mb-2">&nbsp;</div>
            </div>

        </div>
        <div class="page-ath-gfx"
            style="background-image: url({{ asset('images/ath-gfx.png') }}); no-repeat; background-size:cover; ">
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
    </script>

</body>

</html>
