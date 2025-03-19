<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Change Password | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">

    <link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style type="text/css">
        .col-md-4 svg {
            max-width: 90%;
            /* Ensure the SVG doesn't exceed the width of the container */
            max-height: 90%;
            /* Ensure the SVG doesn't exceed the height of the container */
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle input[type="password"] {
            padding-right: 30px;
        }

        .password-toggle .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-toggle .toggle-password-2 {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-toggle .toggle-password-3 {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body class="admin-dashboard page-user">
    @include('includes.nav')


    <div class="page-content">
        <div class="container">
            <div class="card content-area offset-md-2 col-md-8 jutify-center">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title mb-3">
                            Change Password
                        </h4>
                    </div>

                    <div>
                        <form method="post" action="{{ route('updatePassword') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 password-toggle">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Current Password</label>
                                        <div class="input-wrap">
                                            <input id="password" name="current_password" class="input-bordered"
                                                required="required" type="password" value=""
                                                placeholder="Current Password">
                                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 password-toggle">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">New Password</label>
                                        <div class="input-wrap">
                                            <input id="password2" name="new_password" class="input-bordered"
                                                required="required" type="password" value=""
                                                placeholder="New Password">
                                            <span class="toggle-password-2" onclick="togglePassword2Visibility()">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 password-toggle">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Confirm Password</label>
                                        <div class="input-wrap">
                                            <input id="password3" name="password_confirmation" class="input-bordered"
                                                required="required" type="password" value=""
                                                placeholder="Password Confirmation">
                                            <span class="toggle-password-3" onclick="togglePassword3Visibility()">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-md btn-primary" type="submit">Change Password</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="footer-bar">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12">
                    <div class="copyright-text text-center pb-3">&copy; {{ date('Y') }} {{ env('APP_NAME') }}.
                        All
                        Rights Reserved. <br>Application Developed by <a href="{{ env('DEVELOPER_WEBSITE') }}"
                            target="_blank">{{ env('APP_DEVELOPER') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="ajax-modal"></div>


    <div class="page-overlay">
        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        const cacheRoute = @json(route('super.clearCache'));

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

        function togglePassword3Visibility() {
            var passwordInput = document.getElementById("password3");
            var icon = document.querySelector(".toggle-password-3 i");

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


    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire(
                'Successful',
                {{ Js::from(Session::get('success')) }},
                'success'
            )
        </script>
    @endif

    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire(
                'Error',
                {{ Js::from(Session::get('error')) }},
                'error'
            )
        </script>
    @endif

</body>

</html>
