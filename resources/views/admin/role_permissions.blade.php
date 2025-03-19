<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>User Permissions | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">
    <style type="text/css">
        .nobreak {
            white-space: nowrap;
        }

        @media (max-width: 576px) {
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
            <div class="row">
                <div class="main-content col-lg-12">
                    <div class="content-area card">
                        <div class="card-innr">
                            <div class="card-head has-aside">
                                <h4 class="card-title">User Permissions</h4>

                            </div>
                            <p><b>Permissions For User Role: <u>{{ $role->role }}</u></b></p>

                            <div class="gaps-2x"></div>
                            <div class="card-text table-responsive">
                                <table class="table mb-0 text-nowrap table-hover table-centered table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Platform Features</th>
                                            <th scope="col">Feature Permission</th>
                                            <th scope="col">Can Create</th>
                                            <th scope="col">Can Edit</th>
                                            <th scope="col">Can Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($platformFeatures as $feature)
                                            <tr>
                                                <td> <strong>{{ $feature->feature }} </strong></td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        <a href="{{ route('super.revokeFeaturePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                class="btn btn-secondary btn-sm">Revoke
                                                                Permission</button></a>
                                                    @else
                                                        <a href="{{ route('super.grantFeaturePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                class="btn btn-primary btn-sm" style="background-color:#754ffe; border-color:#754ffe">Grant
                                                                Permission</button></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->createPermission($feature->id) == 1)
                                                            <a href="{{ route('super.revokeCreatePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                    class="btn btn-secondary btn-sm">Revoke
                                                                    Permission</button></a>
                                                        @else
                                                            <a href="{{ route('super.grantCreatePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                    class="btn btn-primary btn-sm" style="background-color:#754ffe; border-color:#754ffe">Grant
                                                                    Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-default btn-sm" style="background-color:#64748b; border-color:#64748b">Grant
                                                            Permission</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->editPermission($feature->id) == 1)
                                                            <a href="{{ route('super.revokeEditPermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                    class="btn btn-secondary btn-sm">Revoke
                                                                    Permission</button></a>
                                                        @else
                                                            <a href="{{ route('super.grantEditPermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                    class="btn btn-primary btn-sm" style="background-color:#754ffe; border-color:#754ffe">Grant
                                                                    Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-default btn-sm" style="background-color:#64748b; border-color:#64748b">Grant
                                                            Permission</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->deletePermission($feature->id) == 1)
                                                            <a href="{{ route('super.revokeDeletePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                    class="btn btn-secondary btn-sm">Revoke
                                                                    Permission</button></a>
                                                        @else
                                                            <a href="{{ route('super.grantDeletePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                    class="btn btn-primary btn-sm" style="background-color:#754ffe; border-color:#754ffe">Grant
                                                                    Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-default btn-sm" style="background-color:#64748b; border-color:#64748b">Grant
                                                            Permission</button>
                                                    @endif
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
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}"></script>


    @include('sweetalert::alert')

    <script type="text/javascript">
        const cacheRoute = @json(route('super.clearCache'));
    </script>

    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire({
                text: {{ Js::from(Session::get('success')) }},
                icon: "success",
                showConfirmButton: false,
                toast: true,
                width: 450,
                timer: 4000,
                position: 'top-right',
            })
        </script>
    @endif

    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire({
                text: {{ Js::from(Session::get('error')) }},
                icon: "error",
                showConfirmButton: false,
                toast: true,
                width: 450,
                timer: 4000,
                position: 'top-right',
            })
        </script>
    @endif



</body>

</html>
