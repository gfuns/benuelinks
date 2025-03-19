<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>User Roles | {{ env('APP_NAME') }}</title>
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
    </style>
</head>

<body class="admin-dashboard page-user">
    @include('includes.nav')


    <div class="page-content">
        <div class="container">
            <div class="card content-area">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title mb-3">
                            User Role Management
                        </h4>
                        @if (app('Menu')->canCreate(Auth::user()->role_id, 1) == true)
                            <div class="relative d-inline-block d-md-none mb-3">
                                <a href="#" class="btn btn-light-alt btn-xs btn-icon toggle-tigger"><em
                                        class="ti ti-more-alt"></em></a>
                                <div class="toggle-class dropdown-content dropdown-content-center-left pd-2x">
                                    <div class="card-opt data-action-list">
                                        <ul class="btn-grp btn-grp-block guttar-20px guttar-vr-10px">
                                            <li>
                                                <a href="#" class="btn btn-auto btn-xs btn-primary"
                                                    data-toggle="modal" data-target="#addUser">
                                                    <em class="fas fa-plus-circle"> </em>
                                                    <span>Add New Role</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card-opt data-action-list d-none d-md-inline-flex mb-3">
                                <ul class="btn-grp btn-grp-block guttar-20px">
                                    <li>
                                        <a href="#" class="btn btn-auto btn-xs btn-primary" data-toggle="modal"
                                            data-target="#addUser">
                                            <em class="fas fa-plus-circle"> </em><span>NEW <span
                                                    class="d-none d-md-inline-block">USER ROLE</span></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="data-table  dt-filter-init admin-tnx nobreak">
                            <thead>
                                <tr class="data-item data-head">
                                    <th class="data-col sli">S/No.</th>
                                    <th class="data-col sli">User Role</th>
                                    <th class="data-col sli">Permissions</th>
                                    <th class="data-col sli">Date Created</th>
                                    @if (app('Menu')->canEdit(Auth::user()->role_id, 1) == true)
                                        <th class="data-col sli"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userRoles as $ur)
                                    <tr class="data-item" id="tnx-item-{{ $ur->id }}">
                                        <td class="data-col dt-tnxno">
                                            <span
                                                class="sub sub-s2 token-amount">{{ $loop->index + 1 }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">{{ $ur->role }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 amount-pay">{{ $ur->totalPermissions() }}
                                                Permissions Found</span>
                                        </td>
                                        <td class="data-col dt-token">
                                            <span
                                                class="sub sub-s2 amount-pay">{{ date_format($ur->created_at, 'jS M, Y g:i A') }}</span>
                                        </td>
                                        @if (app('Menu')->canEdit(Auth::user()->role_id, 1) == true)
                                            <td class="data-col text-right">

                                                    <div class="relative d-inline-block">
                                                        <a href="#"
                                                            class="btn btn-light-alt btn-xs btn-icon toggle-tigger"><em
                                                                class="ti ti-more-alt"></em></a>
                                                        <div
                                                            class="toggle-class dropdown-content dropdown-content-top-left">
                                                            <ul id="more-menu-668" class="dropdown-list">
                                                                <li><a href="#"
                                                                        data-roleid="{{ $ur->id }}"
                                                                        data-role="{{ $ur->role }}"
                                                                       data-toggle="modal"
                                                                        data-target="#updateUserRole"><em class="fas fa-edit"></em>Update
                                                                        Details</a>
                                                                </li>
                                                                <li><a
                                                                        href="{{ route('super.managePermissions', [$ur->id]) }}"><em class="fas fa-wrench"></em>Manage
                                                                        Permissions</a></li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if (count($userRoles) < 1)
                                    <tr>
                                        <td colspan="7">
                                            <div class="bg-light text-center rounded pdt-5x pdb-5x">
                                                <p><em class="ti ti-server fs-24"></em><br>No User Role Found!
                                                </p>
                                                <p><a class="btn btn-primary btn-auto"
                                                        href="{{ route('super.userRoles') }}">View
                                                        All User Roles</a>
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
                        <h3 class="popup-title">Add New User</h3>
                        <form action="{{ route('super.storeUserRole') }}" method="POST"
                            class="adduser-form validate-modern" autocomplete="false">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">User Role</label>
                                        <div class="input-wrap">
                                            <input name="role" class="input-bordered"
                                                required="required" type="text" placeholder="User Role">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="gaps-1x"></div>
                            <button class="btn btn-md btn-primary" type="submit">Add User Role</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    @endif

    @if (app('Menu')->canEdit(Auth::user()->role_id, 1) == true)
        <div class="modal fade" id="updateUserRole" tabindex="-1">
            <div class="modal-dialog modal-dialog-md modal-dialog-centered">
                <div class="modal-content">
                    <a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em
                            class="ti ti-close"></em></a>
                    <div class="popup-body popup-body-md">
                        <h3 class="popup-title">Update Role Information</h3>
                        <form action="{{ route('super.updateUserRole') }}" method="POST"
                            class="adduser-form validate-modern" autocomplete="false">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">User Role</label>
                                        <div class="input-wrap">
                                            <input id="role" name="role" class="input-bordered"
                                               required="required" type="text"
                                                placeholder="User Role">
                                        </div>
                                    </div>
                                </div>

                                <input id="roleid" type="hidden" name="role_id" class="form-control" required>
                            </div>
                            <div class="gaps-1x"></div>
                            <button class="btn btn-md btn-primary" type="submit">Update User Role</button>
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
    <script src="{{ asset('assets/js/app.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        const cacheRoute = @json(route('super.clearCache'));
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
