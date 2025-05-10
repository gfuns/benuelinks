@extends('admin.layouts.app')
@section('content')
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
    </script>
@endsection
