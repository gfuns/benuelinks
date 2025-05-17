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

            .page-ath-form{
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
                <h2 class=""><small><strong>Verify Your Email Address!</strong></small></h2>
                <small style="font-size: 16px; line-height: 25px">A verification code was sent to your registered email
                    <strong>{{ Auth::user()->email }}</strong>. <br /><br />Please input the code to verify your
                    email.</small>


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
                    <form class="validate" action="{{ route('verifyEmail') }}" method="POST">
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
                        <button type="submit" class="btn btn-primary btn-block mt-2">Verify Email</button>
                    </form>

                </div>


                <div class="gaps-1x"></div>
                <div class="form-note text-center">
                    <p>By continuing, you agree to our <a href="/terms"><strong>Terms</strong></a> and <a
                            href="/privacy-policy"><strong>Policies</strong></a></p>
                    <p>If you did not get the email please <a href="{{ route('sendVerificationMail') }}"><b>Request
                            Another.</b></a></p>
                </div>
                <div class="gaps-2x"></div>
                <hr />

                <div class="form-note text-center">

                </div>

                <div class="gaps-4x"></div>
                <div class="form-note text-center">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                        <strong><u>Sign Out</u></strong>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
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
