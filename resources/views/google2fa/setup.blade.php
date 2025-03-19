
<!DOCTYPE html>
<html lang="en">

<head> <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="keywords" content="">
    <meta name="author" content="GBenue Digital Infrastructure Company">


    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Libs CSS -->
    <link href="{{ asset('tfa/fonts/feather/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('tfa/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('tfa/libs/mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('tfa/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('tfa/css/theme.min.css') }}">
    <title>{{ env('APP_NAME') }} | Login</title>


    <style type="text/css">
        .password-toggle {
            position: relative;
        }

        .password-toggle input[type="password"] {
            padding-right: 30px;
        }

        .password-toggle .toggle-password {
            position: absolute;
            top: 72%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        [data-theme="dark"] ::placeholder {
            color: white;
        }
    </style>
</head>

<body>
    <!-- Page content -->
    <main>
        <section class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center g-0 min-vh-100">

                <div class="col-lg-5 col-md-8 py-8 py-xl-0">
                    <!-- Card -->
                    <div class="card shadow ">
                        <!-- Card body -->
                        <div class="card-body p-6">
                            <div class="mb-4 row">
                                <div class="col-12 text-center">
                                    <a href="/"><img src="{{ asset('assets/logo.png') }}" class="mb-4"
                                            alt=""style="height: 50px"></a>
                                </div>
                                <div class="col-12 ">
                                    <h2 class="mb-1 fw-bold text-center">Google Authenticator Setup</h2>
                                </div>
                            </div>
                            <!-- Form -->
                            <form action="{{ route('enableGA') }}" method="POST" autocomplete="off">
                                @csrf
                                <p style="color: black"><strong>Step 1:</strong> Install this app from <a class="text-success"
                                        target="_blank"
                                        href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" style="font-weight: bold">Google
                                        Play Store</a>  or <a class="text-success" target="_blank"
                                        href="https://itunes.apple.com/us/app/google-authenticator/id388497605" style="font-weight: bold">App
                                        Store</a>.</p>
                                <p style="color: black">
                                    <strong>Step 2:</strong> Scan the below QR code by your Google Authenticator
                                    app, or you can add account manually.
                                </p>
                                <p style="color: black">
                                    <strong>Manually add Account:</strong><br>
                                    <strong class="text-head">Account Name:</strong> &nbsp;
                                    {{ env('APP_NAME') }} <br>
                                    <strong class="text-head">Secret Key:</strong> &nbsp; {{ $google2faSecret }}
                                </p>
                                <div class="row" style="padding: 0px; margin:0px">
                                    <!-- form group -->
                                    <div class="col-md-4 col-12">
                                        <div style="width: 160px; display: flex; overflow: hidden;">
                                            {!! $QRImage !!}
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-8 col-12">
                                        <div class="input-item mb-2">
                                            <label for="google2fa_code" style="color: black"><strong>Enter Google Authenticator
                                                    Code</strong></label>
                                            <input id="google2fa_code" type="text" class="form-control"
                                                name="google2fa_code" required maxlength="6"
                                                data-msg-required="Required." data-msg-maxlength="Maximum 6 chars."
                                                placeholder="Enter the Google Authenticator Code">
                                        </div>
                                        <input type="hidden" name="google2fa_secret"
                                            value="{{ $google2faSecret }}">
                                        <button type="submit" class="btn btn-success btn-sm enable-2fa">Enable
                                            Google
                                            Authenticator</button>
                                    </div>
                                </div>

                                <p class="p-3 text-danger">
                                    <strong>Note:</strong> After activating this option, if
                                    you loose your phone or uninstall the Google Authenticator app you will
                                    loose access to your account.
                                </p>
                                <!--end col-->

                                <div class="text-center col-12">
                                    <p class="mt-4 mb-0"><small class="mr-2 text-dark" style="font-weight: bold">&copy; Copyright
                                            {{ date('Y') }} &nbsp; {{ env('APP_NAME') }} <br />
                                            All Rights Reserved.</small>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="{{ asset('tfa/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('tfa/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('tfa/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('tfa/js/theme.min.js') }}"></script>
    @include('sweetalert::alert')
    <script src="{{ asset('tfa/js/vendors/sweetalert2.all.min.js') }}"></script>


    <script type="text/javascript">
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var icon = document.querySelector(".toggle-password i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fe-eye");
                icon.classList.add("fe-eye-off");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fe-eye-off");
                icon.classList.add("fe-eye");
            }
        }
    </script>

</body>

</html>

