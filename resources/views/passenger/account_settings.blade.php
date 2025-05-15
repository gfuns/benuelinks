<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Peace Mass Transit (PMT) | Account Settings</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-blue.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body class="admin-dashboard page-user">
    @include('passenger.includes.nav')

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="main-content col-lg-8">
                    <div class="content-area card">
                        <div class="card-innr">
                            <div class="card-head mb-4">
                                <h4 class="card-title">Account Settings</h4>
                            </div>
                            <div class="nav nav-tabs nav-tabs-line">
                                <ul class="nav mb-0" id="myTab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                            href="#accountInfo">Profile Information</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                            href="#changePassword">Change Password</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#secutity">Change
                                            Wallet PIN</a></li>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="accountInfo">
                                    <div class="w-xl-16x">
                                        <form class="validate-modern" action="{{ route('passenger.updateProfile') }}"
                                            method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="last-name" class="input-item-label">Last
                                                            Name</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" type="text" id="last-name"
                                                                name="last_name" required="required"
                                                                placeholder="Enter Last Name" minlength="3"
                                                                value="{{ Auth::user()->last_name }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="other-names" class="input-item-label">Other
                                                            Names</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" type="text"
                                                                id="other-names" name="other_names"
                                                                placeholder="Enter Other Names" minlength="3"
                                                                value="{{ Auth::user()->other_names }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="email-address" class="input-item-label">Email
                                                            Address</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" type="text"
                                                                id="email-address" name="email" required="required"
                                                                placeholder="Enter Email Address"
                                                                value="{{ Auth::user()->email }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="mobile-number" class="input-item-label">Mobile
                                                            Number</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" type="text"
                                                                id="mobile-number" name="phone_number"
                                                                placeholder="Enter Mobile Number"
                                                                value="{{ Auth::user()->phone_number }}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="nok-name" class="input-item-label">Next Of Kin's
                                                            Name</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" type="text"
                                                                id="nok-name" name="nok_name"
                                                                placeholder="Enter Next Of Kin's Name"
                                                                value="{{ Auth::user()->nok }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="nok-phone" class="input-item-label">Next Of Kin's
                                                            Phone Number</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" type="text"
                                                                id="nok-phone" name="nok_phone"
                                                                placeholder="Enter Next Of Kin's Phone Number"
                                                                value="{{ Auth::user()->nok_phone }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="gaps-1x"></div>
                                            <div class="d-sm-flex justify-content-between align-items-center">
                                                <button type="submit" class="btn btn-primary profile-update">Update
                                                    Profile Information</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="secutity">
                                    <div class="w-xl-16x">
                                        @if (isset(Auth::user()->wallet_pin))
                                            <form class="validate-modern"
                                                action="{{ route('passenger.updateWalletPin') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-item input-with-label">
                                                            <label for="old-pin" class="input-item-label">Current
                                                                PIN</label>
                                                            <div class="input-wrap">
                                                                <input class="input-bordered" type="password"
                                                                    placeholder="Current PIN" name="current_pin"
                                                                    id="old-pin" required="required" minlength="4" maxlength="4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-item input-with-label">
                                                            <label for="new-pin" class="input-item-label">New
                                                                PIN</label>
                                                            <div class="input-wrap">
                                                                <input class="input-bordered" id="new-pin"
                                                                    type="password" name="new_pin"
                                                                    placeholder="New PIN" required="required"
                                                                    minlength="4" maxlength="4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-item input-with-label">
                                                            <label for="confirm-pin" class="input-item-label">Confirm
                                                                New
                                                                PIN</label>
                                                            <div class="input-wrap">
                                                                <input id="confirm-pin" class="input-bordered"
                                                                    type="password" name="pin_confirmation"
                                                                    placeholder="Confirm New PIN"
                                                                    data-rule-equalTo="#new-pin"
                                                                    data-msg-equalTo="PIN do not match."
                                                                    required="required" minlength="4"
                                                                    maxlength="4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="note note-plane note-info pdb-1x">
                                                    <em class="fas fa-info-circle"></em>
                                                    <p>Wallet PIN should be a minimum of 4 digits.</p>
                                                </div>
                                                <div class="gaps-1x"></div>
                                                <div class="d-sm-flex justify-content-between align-items-center">
                                                    <button type="submit"
                                                        class="btn btn-primary password-update">Update Wallet
                                                        PIN</button>
                                                    <div class="gaps-2x d-sm-none"></div>
                                                </div>
                                            </form>
                                        @else
                                            <div class="col-xl-12 col-12 job-items job-empty">
                                                <div class="text-center mt-4"><i class="far fa-sad-tear"
                                                        style="font-size: 48px"></i>
                                                    <h5 class="mt-3 mb-3">No Active Wallet Found</h5>
                                                    <a href="{{ route('passenger.wallet') }}"><button class="btn btn-info btn-sm">Activate Wallet</button></a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="changePassword">
                                    <div class="w-lg-12x">
                                        <form class="validate-modern"
                                            action="{{ route('passenger.updatePassword') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="old-pass" class="input-item-label">Current
                                                            Password</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" type="password"
                                                                placeholder="Current Password" name="current_password"
                                                                id="old-pass" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="new-pass" class="input-item-label">New
                                                            Password</label>
                                                        <div class="input-wrap">
                                                            <input class="input-bordered" id="new-pass"
                                                                type="password" name="new_password"
                                                                placeholder="New Password" required="required"
                                                                minlength="6">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-item input-with-label">
                                                        <label for="confirm-pass" class="input-item-label">Confirm New
                                                            Password</label>
                                                        <div class="input-wrap">
                                                            <input id="confirm-pass" class="input-bordered"
                                                                type="password" name="password_confirmation"
                                                                placeholder="Confirm Password"
                                                                data-rule-equalTo="#new-pass"
                                                                data-msg-equalTo="Password not match."
                                                                required="required" minlength="6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="note note-plane note-info pdb-1x">
                                                <em class="fas fa-info-circle"></em>
                                                <p>Password should be a minimum of 6 digits and include lower and
                                                    uppercase
                                                    letter.</p>
                                            </div>
                                            <div class="gaps-1x"></div>
                                            <div class="d-sm-flex justify-content-between align-items-center">
                                                <button type="submit" class="btn btn-primary password-update">Update
                                                    Password</button>
                                                <div class="gaps-2x d-sm-none"></div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
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
                        Rights Reserved. <br class="">Application Developed by <a
                            href="{{ env('DEVELOPER_WEBSITE') }}" target="_blank">{{ env('APP_DEVELOPER') }}</a>.
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
    <script src="{{ asset('assets/js/admin.app.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/customcache.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        document.getElementById("settings").classList.add('active');
    </script>

</body>

</html>
