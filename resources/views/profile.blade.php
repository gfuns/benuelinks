<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Profile Information | {{ env('APP_NAME') }}</title>
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
            <div class="card content-area offset-md-2 col-md-8 jutify-center">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title mb-3">
                            Profile Information
                        </h4>
                    </div>

                    <div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">First Name</label>
                                    <div class="input-wrap">
                                        <input name="first_name" class="input-bordered" required="required"
                                            type="text" value="{{ Auth::user()->first_name }}"
                                            placeholder="First Name" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Last Name</label>
                                    <div class="input-wrap">
                                        <input name="last_name" class="input-bordered" required="required"
                                            type="text" value="{{ Auth::user()->last_name }}"
                                            placeholder="Last Name" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Email</label>
                                    <div class="input-wrap">
                                        <input name="email" class="input-bordered" required="required" type="text"
                                            value="{{ Auth::user()->email }}" placeholder="Email" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">User Role</label>
                                    <div class="input-wrap">
                                        <input name="user_role" class="input-bordered" required="required"
                                            type="text" value="{{ Auth::user()->role->role }}"
                                            placeholder="User Role" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <hr />
                    </div>
                    <div>
                        <h4>Feature Permissions</h4>
                        <div class="table-responsive">
                            <table class="table mb-0 text-nowrap table-hover table-centered table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Feature</th>
                                        <th scope="col">Can View</th>
                                        <th scope="col">Can Create</th>
                                        <th scope="col">Can Edit</th>
                                        <th scope="col">Can Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $perm)
                                        <tr>
                                            <td scope="col">{{ $perm->feature->feature }}</td>
                                            <td scope="col">
                                                <center>
                                                    <span style="color:green"><i class="fas fa-check"
                                                            style="font-size:10px"></i></span>
                                                </center>
                                            </td>
                                            <td scope="col">
                                                <center>
                                                    @if ($perm->can_create == 1)
                                                        <span style="color:green"><i class="fas fa-check"
                                                                style="font-size:10px"></i></span>
                                                    @else
                                                        <span style="color:red"><i class="fas fa-times"
                                                                style="font-size:10px"></i></span>
                                                    @endif
                                                </center>
                                            </td>
                                            <td scope="col">
                                                <center>
                                                    @if ($perm->can_edit == 1)
                                                        <span style="color:green"><i class="fas fa-check"
                                                                style="font-size:10px"></i></span>
                                                    @else
                                                        <span style="color:red"><i class="fas fa-times"
                                                                style="font-size:10px"></i></span>
                                                    @endif
                                                </center>
                                            </td>
                                            <td scope="col">
                                                <center>
                                                    @if ($perm->can_delete == 1)
                                                        <span style="color:green"><i class="fas fa-check"
                                                                style="font-size:10px"></i></span>
                                                    @else
                                                        <span style="color:red"><i class="fas fa-times"
                                                                style="font-size:18px"></i></span>
                                                    @endif
                                                </center>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>


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
                        Rights Reserved. <br>Application Developed by <a href="{{ env('DEVELOPER_WEBSITE') }}"
                            target="_blank">{{ env('APP_DEVELOPER') }}</a>.
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
