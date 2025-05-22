@extends('admin.layouts.app')
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
                            <form method="POST" action="{{ route("admin.updatePassword") }}">
                                @csrf

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="currentPassword"><strong>Current Password</strong></label>
                                            <input type="password" name="current_password" class="form-control"
                                                id="currentPassword" placeholder="Old Password" required />

                                            @error('current_password')
                                                <span class="" role="alert">
                                                    <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="newPassword"><strong>New Password</strong></label>
                                            <input type="password" name="new_password" class="form-control" id="newPassword"
                                                placeholder="New Password" required />

                                            @error('new_password')
                                                <span class="" role="alert">
                                                    <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmPassword"><strong>Confirm Password</strong></label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="confirmPassword" placeholder="Confirm Password" required />

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
