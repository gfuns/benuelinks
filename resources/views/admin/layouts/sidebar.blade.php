<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img src="{{ asset('images/logo-light.png') }}" alt="Peace MFB Logo" class="navbar-brand"
                    style="height: 40px" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li id="dashboard" class="nav-item mb-3">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li id="pwdchange" class="nav-item mb-3">
                    <a href="{{ route('admin.changePassword') }}">
                        <i class="fas fa-lock"></i>
                        <p>Change Password</p>
                    </a>
                </li>

                @if (app('Menu')->allowAccess(Auth::user()->role_id, 2) == true)
                    <li id="admins" class="nav-item mb-3">
                        <a href="{{ route('admin.userManagement') }}">
                            <i class="fas fa-users"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                @endif

                @if (app('Menu')->allowAccess(Auth::user()->role_id, 7) == true)
                    <li id="ticketing" class="nav-item mb-3">
                        <a data-bs-toggle="collapse" href="#bookticket" class="collapsed" aria-expanded="false">
                            <i class="fas fa-cash-register"></i>
                            <p>Booking/Ticketing</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="bookticket" style="">
                            <ul class="nav nav-collapse">
                                <li id="book">
                                    <a href="{{ route('admin.bookPassengers') }}">
                                        <span class="sub-item">Book Passengers</span>
                                    </a>
                                </li>
                                <li id="ticket">
                                    <a href="{{ route('admin.issueTickets') }}">
                                        <span class="sub-item">Issue Travel Tickets</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (app('Menu')->allowAccess(Auth::user()->role_id, 6) == true)
                    <li id="schedules" class="nav-item mb-3">
                        <a href="{{ route('admin.travelSchedule') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Travel Schedule</p>
                        </a>
                    </li>
                @endif

                @if (app('Menu')->allowAccess(Auth::user()->role_id, 5) == true)
                    <li id="routes" class="nav-item mb-3">
                        <a href="{{ route('admin.travelRoutes') }}">
                            <i class="fas fa-road"></i>
                            <p>Travel Routes</p>
                        </a>
                    </li>
                @endif

                @if (app('Menu')->allowReport(Auth::user()->role_id) == true)
                    <li id="adminreports" class="nav-item mb-3">
                        <a data-bs-toggle="collapse" href="#reports" class="collapsed" aria-expanded="false">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Reports</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="reports" style="">
                            <ul class="nav nav-collapse">

                                @if (app('Menu')->allowAccess(Auth::user()->role_id, 8) == true)
                                    <li id="financial">
                                        <a href="{{ route('admin.financialReport') }}">
                                            <span class="sub-item">Financial Report</span>
                                        </a>
                                    </li>
                                @endif

                                @if (app('Menu')->allowAccess(Auth::user()->role_id, 9) == true)
                                    <li id="audittrail">
                                        <a href="{{ route('admin.auditTrailReport') }}">
                                            <span class="sub-item">Audit Trail</span>
                                        </a>
                                    </li>
                                @endif

                                @if (app('Menu')->allowAccess(Auth::user()->role_id, 10) == true)
                                    <li id="authlogs">
                                        <a href="{{ route('admin.userAuths') }}">
                                            <span class="sub-item">Authentication Logs</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

                <li id="logout" class="nav-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
