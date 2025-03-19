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
                                src="{{ asset('assets/logo_white.png') }}" /> </span>
                    </a>
                </div>
                <ul class="topbar-nav">
                    <li class="topbar-nav-item relative">
                        <span class="user-welcome d-none d-lg-inline-block">Hello!
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                        <a class="toggle-tigger user-thumb" href="#"><em class="ti ti-user"></em></a>
                        <div
                            class="toggle-class dropdown-content dropdown-content-right dropdown-arrow-right user-dropdown">
                            <div class="user-status">
                                <h6 class="user-status-title">
                                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                </h6>
                                <div class="user-status-balance" style="color:white"><small><a href="#"
                                            style="color:white">{{ Auth::user()->email }}</a></small></div>
                            </div>
                            <ul class="user-links">
                                <li><a href="{{ route('profile') }}"><i class="ti ti-id-badge"></i>My Profile</a>
                                </li>

                                <li><a href="{{ route('changePassword') }}"><i class="ti ti-lock"></i>Change
                                        Password</a>
                                </li>
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

                    <li>
                        <a href="{{ route('dashboard') }}"><em class="ikon ikon-dashboard"></em> Dashboard</a>
                    </li>

                    <li>
                        <a href="{{ route('changePassword') }}"><em class="ti ti-lock"
                                style="font-weight:bold; font-size:16px"></em>&nbsp; Change Password</a>
                    </li>

                    @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 2) == true)
                        <li>
                            <a href="{{ route('singleTransfer') }}"><em class="ikon ikon-transactions"></em> Single
                                Transfer</a>
                        </li>
                    @endif

                    @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 3) == true)
                        <li>
                            <a href="{{ route('bulkTransfer') }}"><em class="ikon ikon-exchange"></em> Bulk
                                Transfer</a>
                        </li>
                    @endif

                    @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 4) == true)
                        <li class="has-dropdown"><a class="drop-toggle" href="javascript:void(0)"><em
                                    class="ikon ikon-docs"></em> Transaction
                                History</a>
                            <ul class="navbar-dropdown">

                                <li><a href="{{ route('singleTransactionHistory') }}">Single Transfer Transactions</a>
                                </li>

                                <li><a href="{{ route('bulkTransactionHistory') }}">Bulk Transfer Transactions</a></li>

                            </ul>
                        </li>
                    @endif

                    @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 1) == true)
                        <li class="has-dropdown"><a class="drop-toggle" href="javascript:void(0)"><em
                                    class="ikon ikon-user"></em>User Management</a>
                            <ul class="navbar-dropdown">

                                <li><a href="{{ route('super.platformFeatures') }}">Platform Features</a></li>

                                <li><a href="{{ route('super.userRoles') }}">Roles & Permissions</a></li>

                                <li><a href="{{ route('super.usermgt') }}">User Management</a></li>

                            </ul>
                        </li>
                    @endif


                </ul>
                <ul class="navbar-btns">
                    <li><a id="" class="btn btn-auto btn-xs btn-dark btn-outline clearCache"
                            href="javascript:void(0)"><em class="ti ti-trash"></em><span>CLEAR CACHE</span></a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
