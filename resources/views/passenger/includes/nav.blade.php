<div class="topbar-wrap">
    <div class="topbar is-sticky">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="topbar-nav d-lg-none">
                    <li class="topbar-nav-item relative">
                        <a class="toggle-nav" href="#">
                            <div class="toggle-icon">
                                <span class="toggle-line"></span>
                                <span class="toggle-line"></span>
                                <span class="toggle-line"></span>
                                <span class="toggle-line"></span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="topbar-logo">
                    <a class="topbar-logo" href="/">
                        <span style="color:white; font-weight:bold; font-size: 24px"><img
                                src="{{ asset('images/logo-light.png') }}" /> </span>
                    </a>
                </div>
                <ul class="topbar-nav">
                    <li class="topbar-nav-item relative">
                        <span class="user-welcome d-none d-lg-inline-block">Hello!
                            {{ Auth::user()->last_name . ', ' . Auth::user()->other_names }}</span>
                        <a class="toggle-tigger user-thumb" href="#"><em class="ti ti-user"></em></a>
                        <div
                            class="toggle-class dropdown-content dropdown-content-right dropdown-arrow-right user-dropdown">
                            <div class="user-status">
                                <h6 class="user-status-title">
                                    {{ Auth::user()->last_name . ', ' . Auth::user()->other_names }}
                                </h6>
                                <div class="user-status-balance" style="color:white"><small><a href="#"
                                            style="color:white">{{ Auth::user()->email }}</a></small></div>
                            </div>
                            <ul class="user-links">
                                <li><a href=""><i class="ti ti-id-badge"></i>My Account</a></li>
                            </ul>
                            <ul class="user-links bg-light">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                            class="ti ti-power-off"></i>Logout</a>
                                </li>
                            </ul>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="navbar">
        <div class="container">
            <div class="navbar-innr">
                <ul class="navbar-menu" id="main-nav">
                    <li id="dashboard" style="margin-right:20px">
                        <a href="{{ route('passenger.dashboard') }}"><em class="ikon ikon-dashboard"></em> Home</a>
                    </li>

                    <li id="wallet" style="margin-right:20px">
                        <a href="{{ route('passenger.wallet') }}"><em class="ikon ikon-wallet"></em> Wallet</a>
                    </li>

                    <li id="pricing" style="margin-right:20px">
                        <a href="{{ route("passenger.pricing") }}"><em class="ikon ikon-sign-ngn"></em>
                            Check Route Price</a>
                    </li>

                    <li id="history" style="margin-right:20px">
                        <a href="{{ route("passenger.bookingHistory") }}"><em class="ikon ikon-transactions"></em>
                            Booking History</a>
                    </li>

                    <li id="referrals" style="margin-right:20px">
                        <a href="{{ route("passenger.referrals") }}"><em class="ikon ikon-user-list"></em>
                            Referrals</a>
                    </li>

                    <li id="settings" style="margin-right:20px">
                        <a href="{{ route("passenger.accountSettings") }}"><em class="ikon ikon-settings"></em>
                            Account Settings</a>
                    </li>

                </ul>



                <ul class="navbar-btns">
                    <li class="m-2">
                        <a id="" class="btn btn-auto btn-xs btn-primary btn-outline-primary" href="/">
                            <em class="fa fa-recycle"></em><span style="font-weight:bold">Visit Website</span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>


</div>
