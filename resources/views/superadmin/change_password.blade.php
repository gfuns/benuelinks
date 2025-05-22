@extends('superadmin.layouts.app')
@section('content')
    <style type="text/css">
        .password-toggle {
            position: relative;
        }

        .password-toggle input[type="password"] {
            padding-right: 30px;
        }

        .password-toggle .toggle-password {
            position: absolute;
            top: 66%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-toggle .toggle-password-2 {
            position: absolute;
            top: 66%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-toggle .toggle-password-3 {
            position: absolute;
            top: 66%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>

    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Change Password</div>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('superadmin.updatePassword') }}">
                                @csrf

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group password-toggle">
                                            <label for="password"><strong>Current Password</strong></label>
                                            <input type="password" name="current_password" class="form-control"
                                                id="password" placeholder="Old Password" required />

                                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                                <i class="fa fa-eye"></i>
                                            </span>

                                            @error('current_password')
                                                <span class="" role="alert">
                                                    <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group password-toggle">
                                            <label for="password2"><strong>New Password</strong></label>
                                            <input type="password" name="new_password" class="form-control" id="password2"
                                                placeholder="New Password" required />

                                            <span class="toggle-password-2" onclick="togglePassword2Visibility()">
                                                <i class="fa fa-eye"></i>
                                            </span>

                                            @error('new_password')
                                                <span class="" role="alert">
                                                    <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group password-toggle">
                                            <label for="password3"><strong>Confirm Password</strong></label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="password3" placeholder="Confirm Password" required />

                                            <span class="toggle-password-3" onclick="togglePassword3Visibility()">
                                                <i class="fa fa-eye"></i>
                                            </span>

                                            @error('new_password')
                                                <span class="" role="alert">
                                                    <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card-action">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById("pwdchange").classList.add('active');

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
@endsection
