<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>User Management | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">
    <link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style type="text/css">
        .nobreak {
            white-space: nowrap;
        }

        @media (min-width: 576px) {
            .sli {
                padding-right: 80px;
            }

            .table td {
                padding-right: 15px;
            }
        }

        legend {
            background-color: #758698;
            /* Bootstrap primary color */
            color: #fff;
            /* Text color */
            /* padding: 5px 15px; */
            /* Padding around the text */
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            /* Slightly rounded corners */
            display: inline-block;
            /* Fit content width */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            /* Optional shadow */
        }
    </style>
</head>

<body class="admin-dashboard page-user">
    @include('includes.nav')


    <div class="page-content">
        <div class="container">
            <div class="card content-area">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title">
                            User Management
                        </h4>
                        @if (app('Menu')->canCreate(Auth::user()->role_id, 1) == true)
                            <div class="relative d-inline-block d-md-none">
                                <a href="#" class="btn btn-light-alt btn-xs btn-icon toggle-tigger"><em
                                        class="ti ti-more-alt"></em></a>
                                <div class="toggle-class dropdown-content dropdown-content-center-left pd-2x">
                                    <div class="card-opt data-action-list">
                                        <ul class="btn-grp btn-grp-block guttar-20px guttar-vr-10px">
                                            <li>
                                                <a href="#" class="btn btn-auto btn-xs btn-primary"
                                                    data-toggle="modal" data-target="#addUser">
                                                    <em class="fas fa-plus-circle"> </em>
                                                    <span>Add User</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card-opt data-action-list d-none d-md-inline-flex">
                                <ul class="btn-grp btn-grp-block guttar-20px">
                                    <li>
                                        <a href="#" class="btn btn-auto btn-xs btn-primary" data-toggle="modal"
                                            data-target="#addUser">
                                            <em class="fas fa-plus-circle"> </em><span>ADD <span
                                                    class="d-none d-md-inline-block">USER</span></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="page-nav-wrap">
                        <div class="page-nav-bar justify-content-between bg-lighter">

                            <div class="search flex-grow-1 pl-lg-4 w-100 w-sm-auto">
                                <form action="" method="GET" autocomplete="off">
                                    <div class="input-wrap">
                                        <span class="input-icon input-icon-left"><em class="ti ti-search"></em></span>
                                        <input type="search" class="input-solid input-transparent"
                                            placeholder="Quick user search using name or email"
                                            value="{{ $filter == 'quick' ? $keyword : '' }}" name="search">
                                        <input type="hidden" name="filter" value="quick">
                                    </div>
                                </form>
                            </div>
                            <div class="tools w-100 w-sm-auto">
                                <ul class="btn-grp guttar-8px">

                                    <li><a href="#"
                                            class="btn btn-light btn-sm btn-icon btn-outline bg-white advsearch-opt">
                                            <em class="ti ti-panel"></em> </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="search-adv-wrap hide">
                            <form class="adv-search" id="adv-search" action="" method="GET" autocomplete="off">
                                <div class="adv-search">
                                    <div class="row align-items-end guttar-20px guttar-vr-15px">
                                        <div class="col-lg-6">
                                            <div class="input-grp-wrap">
                                                <span class="input-item-label input-item-label-s2 text-exlight">Advanced
                                                    Search</span>
                                                <div class="input-grp align-items-center bg-white">
                                                    <div class="input-wrap flex-grow-1">
                                                        <input class="input-solid input-solid-sm input-transparent p-2"
                                                            type="text" placeholder="Search by user" name="search"
                                                            value="{{ $keyword }}">
                                                    </div>
                                                    <ul class="search-type">
                                                        <li class="input-wrap input-radio-wrap">
                                                            <input name="by" value=""
                                                                class="input-radio-select" id="advs-by-name"
                                                                type="radio" id="advs-by-name" checked>
                                                            <label for="advs-by-name">Name</label>
                                                        </li>
                                                        <li class="input-wrap input-radio-wrap">
                                                            <input name="by" value="email"
                                                                class="input-radio-select" id="advs-by-email"
                                                                type="radio" id="advs-by-email">
                                                            <label for="advs-by-email">Email</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-lg-2 col-mb-6">
                                            <div class="input-wrap input-with-label">
                                                <label
                                                    class="input-item-label input-item-label-s2 text-exlight">Account
                                                    Status</label>
                                                <select name="status"
                                                    class="select select-sm select-block select-bordered"
                                                    data-dd-class="search-off">
                                                    <option value="">Any Status</option>
                                                    <option value="active"
                                                        @if ($status == 'active') selected @endif>Active
                                                    </option>
                                                    <option value="suspended"
                                                        @if ($status == 'suspended') selected @endif>Suspended
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-2 col-mb-6">
                                            <div class="input-wrap input-with-label">
                                                <label
                                                    class="input-item-label input-item-label-s2 text-exlight">Account
                                                    Role</label>
                                                <select name="role"
                                                    class="select select-sm select-block select-bordered"
                                                    data-dd-class="search-off">
                                                    <option value="">Any Role</option>
                                                    @foreach ($userRoles as $ur)
                                                        <option value="{{ $ur->id }}"
                                                            @if ($role == $ur->id) selected @endif>
                                                            {{ $ur->role }}
                                                        </option>
                                                    @endforeach
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-2 col-mb-6">
                                            <div class="input-wrap">
                                                <input type="hidden" name="filter" value="advanced">
                                                <button class="btn btn-sm btn-sm-s2 btn-auto btn-primary">
                                                    <em class="ti ti-search width-auto"></em><span>Search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($filter != null)
                            <div class="search-adv-result">
                                <div class="search-info">Found <span
                                        class="search-count">{{ number_format(count($users), 0) }}</span> Users.
                                </div>
                                <ul class="search-opt">
                                    @if ($keyword != null)
                                        <li><a
                                                href="/portal/user-management?status={{ $status }}&amp;role={{ $role }}&amp;filter={{ $filter }}">Search
                                                Keyword:
                                                <span>{{ $keyword }}</span></a>
                                        </li>
                                    @endif
                                    @if ($status != null)
                                        <li><a
                                                href="/portal/user-management?search={{ $keyword }}&amp;role={{ $role }}&amp;filter={{ $filter }}">Status:
                                                <span>{{ ucwords($status) }}</span></a>
                                        </li>
                                    @endif
                                    @if ($role != null)
                                        <li><a
                                                href="/portal/user-management?search={{ $keyword }}&amp;status={{ $status }}&amp;filter={{ $filter }}">Role
                                                Type: <span>{{ \App\Models\UserRole::find($role)->role }}</span></a>
                                        </li>
                                    @endif
                                    <li><a href="{{ route('super.usermgt') }}" class="link link-underline">Clear
                                            All</a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="data-table user-list nobreak">
                            <thead>
                                <tr class="data-item data-head">
                                    <th class="data-col data-col-wd-sm">S/No.</th>
                                    <th class="data-col data-col-wd-md filter-data dt-user sli">User's Name</th>
                                    <th class="data-col data-col-wd-md dt-token sli">Email</th>
                                    <th class="data-col data-col-wd-md dt-token sli">Phone Number</th>
                                   <th class="data-col data-col-wd-md dt-token sli">Role</th>
                                    <th class="data-col data-col-wd-md dt-token sli">Status</th>
                                    @if (app('Menu')->canEdit(Auth::user()->role_id, 1) == true)
                                        <th class="data-col data-col-wd-md dt-token sli"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $usr)
                                    <tr class="data-item">
                                        <td class="data-col data-col-wd-sm">
                                            <span class="sub sub-s2 sub-email">{{ $loop->index + 1 }}</span>
                                        </td>
                                        <td class="data-col data-col-wd-md dt-user">
                                            <span
                                                class="sub sub-s2 sub-email">{{ $usr->last_name . ' ' . $usr->first_name }}</span>
                                        </td>
                                        <td class="data-col data-col-wd-md dt-token">
                                            <span class="sub sub-s2 sub-email">{{ $usr->email }}</span>
                                        </td>
                                        <td class="data-col data-col-wd-md dt-token">
                                            <span class="sub sub-s2 sub-email">{{ $usr->phone_number }}</span>
                                        </td>
                                        <td class="data-col data-col-wd-md dt-token">
                                            <span class="sub sub-s2">{{ $usr->role->role }}</span>
                                        </td>

                                        <td class="data-col data-col-wd-md dt-token">
                                            <span class="sub sub-s2 token-amount">
                                                @if ($usr->status == 'active')
                                                    <span class="badge text-success bg-light-success">
                                                        {{ ucwords($usr->status) }}</span>
                                                @else
                                                    <span class="badge text-danger bg-light-danger">
                                                        {{ ucwords($usr->status) }}</span>
                                                @endif
                                            </span>
                                        </td>
                                        @if (app('Menu')->canEdit(Auth::user()->role_id, 1) == true)
                                            <td class="data-col data-col-wd-md text-right">
                                                <div class="relative d-inline-block">
                                                    <a href="#"
                                                        class="btn btn-light-alt btn-xs btn-icon toggle-tigger"><em
                                                            class="ti ti-more-alt"></em></a>
                                                    <div
                                                        class="toggle-class dropdown-content dropdown-content-top-left">
                                                        <ul class="dropdown-list more-menu-3511">

                                                            <li><a class="front resetUserPassword" href="#"
                                                                    data-toggle="modal" data-target="#editUser"
                                                                    data-userid="{{ $usr->id }}"
                                                                    data-fname="{{ $usr->first_name }}"
                                                                    data-sname="{{ $usr->last_name }}"
                                                                    data-email="{{ $usr->email }}"
                                                                    data-phone="{{ $usr->phone_number }}"
                                                                    data-role="{{ $usr->role_id }}">
                                                                    <em class="fas fa-edit"></em>Edit Details</a></li>
                                                            @if ($usr->status == 'active')
                                                                <li><a href="#"
                                                                        data-userid="{{ $usr->id }}"
                                                                        class="front suspendUser"><em
                                                                            class="fas fa-ban"></em>Suspend</a></li>
                                                            @else
                                                                <li><a href="#"
                                                                        data-userid="{{ $usr->id }}"
                                                                        class="front activateUser"><em
                                                                            class="fas fa-check"></em>Activate</a></li>
                                                            @endif

                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if (count($users) < 1)
                                    <tr>
                                        <td colspan="8">
                                            <div class="bg-light text-center rounded pdt-5x pdb-5x">
                                                <p><em class="ti ti-server fs-24"></em><br>No User found!</p>
                                                <p><a class="btn btn-primary btn-auto btn-xs"
                                                        href="{{ route('super.usermgt') }}">View All Users</a>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-bar">


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

    @if (app('Menu')->canCreate(Auth::user()->role_id, 1) == true)
        <div class="modal fade" id="addUser" tabindex="-1">
            <div class="modal-dialog modal-dialog-md modal-dialog-centered">
                <div class="modal-content">
                    <a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em
                            class="ti ti-close"></em></a>
                    <div class="popup-body popup-body-md">
                        <h3 class="popup-title">Create User Account</h3>
                        <form action="{{ route('super.storeUser') }}" method="POST"
                            class="adduser-form validate-modern" autocomplete="false">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Surname</label>
                                        <div class="input-wrap">
                                            <input name="last_name" class="input-bordered" minlength="3"
                                                required="required" type="text" placeholder="User Last Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Other Names</label>
                                        <div class="input-wrap">
                                            <input name="first_name" class="input-bordered" minlength="3"
                                                required="required" type="text" placeholder="User First Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Email Address</label>
                                        <div class="input-wrap">
                                            <input class="input-bordered" required="required" name="email"
                                                type="email" placeholder="Email address">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Phone Number</label>
                                        <div class="input-wrap">
                                            <input name="phone_number" class="input-bordered"
                                                placeholder="Phone Number" type="text" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">User Role</label>
                                        <select id="taskrole" name="role" class=" select-bordered select-block"
                                            required="required">
                                            <option value="">Select User Role</option>
                                            @foreach ($userRoles as $ur)
                                                <option value="{{ $ur->id }}" data-roletype="{{ $ur->role_type }}">{{ $ur->role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="gaps-1x"></div>
                            <center><button class="btn btn-md btn-primary" type="submit">Create User Account</button>
                            </center>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    @endif

    @if (app('Menu')->canEdit(Auth::user()->role_id, 1) == true)
        <div class="modal fade" id="editUser" tabindex="-1">
            <div class="modal-dialog modal-dialog-md modal-dialog-centered">
                <div class="modal-content">
                    <a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em
                            class="ti ti-close"></em></a>
                    <div class="popup-body popup-body-md">
                        <h3 class="popup-title">Update User Information</h3>
                        <form action="{{ route('super.updateUser') }}" method="POST"
                            class="adduser-form validate-modern" autocomplete="false">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">First Name</label>
                                        <div class="input-wrap">
                                            <input id="fname" name="first_name" class="input-bordered"
                                                minlength="3" required="required" type="text"
                                                placeholder="User First Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Last Name</label>
                                        <div class="input-wrap">
                                            <input id="sname" name="last_name" class="input-bordered"
                                                minlength="3" required="required" type="text"
                                                placeholder="User Last Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Email Address</label>
                                        <div class="input-wrap">
                                            <input id="email" class="input-bordered" required="required"
                                                name="email" type="email" placeholder="Email address">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Phone Number</label>
                                        <div class="input-wrap">
                                            <input id="phone" name="phone_number" class="input-bordered"
                                                placeholder="Phone Number" type="text" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">User Role</label>
                                        <select id="utaskrole" name="role" class=" select-bordered select-block"
                                            required="required">
                                            <option value="">Select User Role</option>
                                            @foreach ($userRoles as $ur)
                                                <option value="{{ $ur->id }}" data-roletype="{{ $ur->role_type }}">{{ $ur->role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <input id="userid" type="hidden" name="user_id" class="form-control" required>
                            <div class="gaps-1x"></div>
                            <center><button class="btn btn-md btn-primary" type="submit">Update User Information</button></center>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    @endif





    <div class="page-overlay">
        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/admin.app.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}?ver={{ date('his') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        const cacheRoute = @json(route('super.clearCache'));
        const suspendUserRoute = @json(route('super.suspendUser'));
        const activateUserRoute = @json(route('super.activateUser'));
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
