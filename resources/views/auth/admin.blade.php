<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="{{ env("APP_NAME") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ env("APP_NAME") }}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="images/favicon.png">
    <!-- Page Title  -->
    <title>Administrator Sign In | {{ env("APP_NAME") }}</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('dash/assets/css/dashlite.css') }}?ver=2.2.0">
    <link id="skin-default" rel="stylesheet" href="{{ asset('dash/assets/css/theme.css') }}?ver=2.2.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Scripts -->

    <style type="text/css">
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* align-items: center; */
            min-height: 100vh;
            background: linear-gradient(to bottom right, #4a90e2, #50c7c7);
            color: #333;
            overflow: hidden;
        }

         /* Footer styling */
         .footer {
            text-align: center;
            color: # !important;
            font-size: 1rem;
            margin-top: 20px;
            padding: 10px 0;
            position: absolute;
            bottom: 10px;
            width: 100%;
            /* z-index: 2; */
        }

        /* Ribbon effect */
        .ribbon-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .ribbon {
            position: absolute;
            top: -50px;
            width: 6px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 3px;
            opacity: 0;
            animation: fall linear infinite;
        }

        /* Keyframes for the falling animation */
        @keyframes fall {
            0% {
                opacity: 1;
                transform: translateY(-50px) rotate(15deg);
            }

            100% {
                opacity: 0;
                transform: translateY(100vh) rotate(45deg);
            }
        }

        /* Styling for multiple ribbons with different colors, delays, and speeds */
        .ribbon:nth-child(1) {
            left: 10%;
            background-color: #ffadad;
            animation-duration: 4s;
            animation-delay: 0s;
        }

        .ribbon:nth-child(2) {
            left: 20%;
            background-color: #ffd6a5;
            animation-duration: 3.5s;
            animation-delay: 0.5s;
        }

        .ribbon:nth-child(3) {
            left: 30%;
            background-color: #fdffb6;
            animation-duration: 4.5s;
            animation-delay: 1s;
        }

        .ribbon:nth-child(4) {
            left: 40%;
            background-color: #caffbf;
            animation-duration: 3s;
            animation-delay: 1.5s;
        }

        .ribbon:nth-child(5) {
            left: 50%;
            background-color: #9bf6ff;
            animation-duration: 5s;
            animation-delay: 2s;
        }

        .ribbon:nth-child(6) {
            left: 60%;
            background-color: #a0c4ff;
            animation-duration: 4.2s;
            animation-delay: 2.5s;
        }

        .ribbon:nth-child(7) {
            left: 70%;
            background-color: #bdb2ff;
            animation-duration: 3.8s;
            animation-delay: 3s;
        }

        .ribbon:nth-child(8) {
            left: 80%;
            background-color: #ffc6ff;
            animation-duration: 4.7s;
            animation-delay: 3.5s;
        }

        .ribbon:nth-child(9) {
            left: 90%;
            background-color: #ffadad;
            animation-duration: 3.3s;
            animation-delay: 4s;
        }

        .ribbon:nth-child(10) {
            left: 15%;
            background-color: #caffbf;
            animation-duration: 4.5s;
            animation-delay: 4.5s;
        }
    </style>
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <!-- Falling Ribbons -->
    <div class="ribbon-container">
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
        <div class="ribbon"></div>
    </div>

    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="/" class="logo-link">
                                <img class="logo-img logo-img-lg" src="{{ asset('images/logo-light.png') }}" alt="logo">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sign-In</h4>
                                        <div class="nk-block-des">
                                            <p>Access The Adminstrative Dashboard.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('login') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Email</label>
                                        </div>
                                        <input type="email" class="form-control form-control-lg" id="default-01"
                                            name="email" placeholder="Email" required="required">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <span class="form-icon form-icon-right password-icon">
                                                <em class="icon far fa-eye" onclick="togglePasswordVisibility()"></em>
                                            </span>
                                            <input type="password" class="form-control form-control-lg" id="password"
                                                name="password" placeholder="Password" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-success btn-block">Sign In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">
                                    <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Privacy Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Help</a>
                                        </li>
                                        <li class="nav-item dropup">
                                            <a class="dropdown-toggle dropdown-indicator has-indicator nav-link"
                                                data-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                <ul class="language-list">
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/english.png') }}"
                                                                alt="" class="language-flag">
                                                            <span class="language-name">English</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/spanish.png') }}"
                                                                alt="" class="language-flag">
                                                            <span class="language-name">Español</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/french.png') }}"
                                                                alt="" class="language-flag">
                                                            <span class="language-name">Français</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="{{ asset('dash/images/flags/turkey.png') }}"
                                                                alt="" class="language-flag">
                                                            <span class="language-name">Türkçe</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="">&copy; 2025 {{ env('APP_NAME') }}. All Rights Reserved.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset('dash/assets/js/bundle.js') }}?ver=2.2.0"></script>
    <script src="{{ asset('dash/assets/js/scripts.js') }}?ver=2.2.0"></script>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var icon = document.querySelector(".password-icon em");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("far-eye");
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
