<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env("APP_NAME") }}">
    <meta name="author" content="{{ env("APP_DEVELOPER") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Password Reset Confirmation | {{ env("APP_NAME") }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver=20241116180">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}?ver=20241116180">

    <style>
        /* Style to make each box look like a digit */
        .verification-box {
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 20px;
            margin: 0 15px;
            color: black;
            border: 1px solid #ccc;
        }

        @media (max-width: 767px) {
            .verification-box {
                width: 55px;
                height: 55px;
                text-align: center;
                font-size: 18px;
                margin: 0 12px;
                color: black;
                border: 1px solid #ccc;
            }
        }

        @media (max-width: 560px) {
            .verification-box {
                width: 50px;
                height: 50px;
                text-align: center;
                font-size: 18px;
                margin: 0 10px;
                color: black;
                border: 1px solid #ccc;
            }
        }

        .customPageContent {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            margin: 100px 200px 100px 200px;
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
                margin: 30px 0px 250px 0px;
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
                    <img class="page-ath-logo-img" src="{{ asset('images/logo.png') }}" alt="Benue Links Logo" style="max-height: 80px">
                </a>
            </div>



            <div class="page-ath-form">
                <h2 class=""><small><strong>Reset Your Password!</strong></small></h2>
                <small style="font-size: 16px; line-height: 25px">A confirmation code was sent to your registered email
                    <strong>{{ $email }}</strong>. <br /><br />Please input the code to confirm your password reset request.</small>


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

                <div class="mt-4 text-center">
                    <form class="validate" action="{{ route('passwordResetVerification') }}" method="POST">
                        @csrf
                        <div class="input-item">
                            <input type="text" name="digit_1" class="verification-box input-bordered" maxlength="1"
                                id="digit1" oninput="moveToNext(this)">
                            <input type="text" name="digit_2" class="verification-box input-bordered" maxlength="1"
                                id="digit2" oninput="moveToNext(this)">
                            <input type="text" name="digit_3" class="verification-box input-bordered" maxlength="1"
                                id="digit3" oninput="moveToNext(this)">
                            <input type="text" name="digit_4" class="verification-box input-bordered" maxlength="1"
                                id="digit4">
                        </div>

                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="btn btn-success btn-block mt-2">Confirm Password Reset</button>
                    </form>

                </div>


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


    <script>
        function moveToNext(currentInput) {
            // Automatically move to the next input box when a digit is entered
            const maxLength = parseInt(currentInput.getAttribute('maxlength'), 10);
            const currentLength = currentInput.value.length;

            if (currentLength >= maxLength) {
                const nextSibling = currentInput.nextElementSibling;

                if (nextSibling && nextSibling.tagName.toLowerCase() === 'input') {
                    nextSibling.focus();
                }
            }
        }
    </script>

</body>

</html>
