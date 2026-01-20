<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env("APP_NAME") }}">
    <meta name="author" content="{{ env("APP_DEVELOPER") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Sign Up | {{ env("APP_NAME") }}</title>
    <link rel="stylesheet" href="assets/css/vendor.bundle.css?ver=20241116180">
    <link rel="stylesheet" href="assets/css/register.css?ver=20241116180">

    <style type="text/css">
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



            <div class="page-ath-form mt-2">
                <h2 class=""><small><strong>Sign Up For Your Benue Links Account!</strong></small></h2>

                {{-- @if ($errors->has('regError'))
                    <div class="alert alert-dismissible fade show alert-danger"><a href="javascript:void(0)"
                            class="close" data-dismiss="alert" aria-label="close" style="color:white">&nbsp;</a>
                        {{ $errors->first('regError') }}
                    </div>
                @endif --}}

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

                <form class="register-form validate validate-modern" method="POST" action="{{ route('register') }}"
                    id="register">
                    @csrf
                    <div style="display: flex; gap: 20px; ">
                        <div class="input-item" style="width:100%">
                            {{-- <label style="font-size:12px; font-weight:bold">First Name <span style="color:red">*</span></label> --}}
                            <input type="text" placeholder="Your Last Name" class="input-bordered" name="last_name"
                                value="{{ old('last_name') }}" data-msg-required="Required." required>
                        </div>
                        <div class="input-item" style="width:100%">
                            {{-- <label style="font-size:12px; font-weight:bold">Last Name <span style="color:red">*</span></label> --}}
                            <input type="text" placeholder="Your First Name" class="input-bordered" name="first_name"
                                value="{{ old('first_name') }}" data-msg-required="Required." required>
                        </div>
                    </div>
                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">Email Address <span style="color:red">*</span></label> --}}
                        <input type="email" placeholder="Your Email Address" class="input-bordered" name="email"
                            value="{{ old('email') }}" data-msg-required="Required."
                            data-msg-email="Enter valid email." required>
                    </div>

                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">Phone Number <span style="color:red">*</span></label> --}}
                        <input type="text" placeholder="Your Phone Number" class="input-bordered" name="phone_number"
                            value="{{ old('phone_number') }}" data-msg-required="Required."
                            data-msg-email="Enter valid phone number." required>
                    </div>

                    <div class="input-item password-toggle">
                        {{-- <label style="font-size:12px; font-weight:bold">Password <span style="color:red">*</span></label> --}}
                        <input type="password" placeholder="Password" class="input-bordered" name="password"
                            id="password" minlength="6" data-msg-required="Required."
                            data-msg-minlength="At least 6 chars." required>
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>

                    <div class="input-item password-toggle">
                        {{-- <label style="font-size:12px; font-weight:bold">Password <span style="color:red">*</span></label> --}}
                        <input id="password2" type="password" placeholder="Confirm Password" class="input-bordered"
                            name="password_confirmation" id="password" minlength="6" data-msg-required="Required."
                            data-msg-minlength="At least 6 chars." required>
                        <span class="toggle-password-2" onclick="togglePassword2Visibility()">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>

                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">How did you hear about us?</label> --}}
                        <select name="referral_channel" class="select select-block select-bordered">
                            <option value="">How did you hear about us?</option>
                            <option value="Twitter" @if (old('referral_channel') == 'Twitter') selected @endif>Twitter</option>
                            <option value="Facebook" @if (old('referral_channel') == 'Facebook') selected @endif>Facebook
                            </option>
                            <option value="Instagram" @if (old('referral_channel') == 'Instagram') selected @endif>Instagram
                            </option>
                            <option value="Newspaper" @if (old('referral_channel') == 'Newspaper') selected @endif>Newspaper
                            </option>
                            <option value="TV" @if (old('referral_channel') == 'TV') selected @endif>TV</option>
                            <option value="Bill Board" @if (old('referral_channel') == 'Bill Board') selected @endif>Bill Board
                            </option>
                            <option value="Referral" @if (old('referral_channel') == 'Referral') selected @endif>Referral
                            </option>
                            <option value="Others" @if (old('referral_channel') == 'Others') selected @endif>Others</option>
                        </select>
                    </div>

                    @if (isset($referralcode))
                        <div class="input-item">
                            {{-- <label style="font-size:12px; font-weight:bold">Phone Number <span style="color:red">*</span></label> --}}
                            <input type="hidden" placeholder="Referral Code" class="input-bordered"
                                name="referral_code" value="{{ $referralcode }}" data-msg-required="Required."
                                data-msg-email="Enter valid referral." readonly required>
                        </div>
                    @endif

                    <input type="hidden" name="invitation_code" value="">
                    <div class="input-item text-left">
                        <input name="terms" class="input-checkbox input-checkbox-md" id="agree"
                            type="checkbox" required="required"
                            data-msg-required="You should accept our terms and policy."
                            {{ old('terms') ? 'checked' : '' }}>
                        <label for="agree">I agree to the <a target="_blank" href="#">Terms</a>
                            and <a target="_blank" href="#">Privacy
                                Policy</a>.</label>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Create Account</button>
                </form>


                <div class="gaps-4x"></div>
                <div class="form-note">
                    Already have an account ? <a href="/login"> <strong>Sign In Instead</strong></a>
                </div>
                <div class="mb-2">&nbsp;</div>
            </div>

        </div>
        <div class="page-ath-gfx"
            style="background-image: url(images/ath-gfx.png); no-repeat; background-size:cover; ">
            <div class="w-100 d-flex justify-content-center">
                <div class="col-md-8 col-xl-5">

                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.bundle.js?ver=20241116180"></script>
    <script src="assets/js/script.js?ver=20241116180"></script>
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
