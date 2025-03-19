<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Dashboard | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">
</head>

<body class="admin-dashboard page-user">
    @include('includes.nav')

    <div class="page-content">
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card height-auto">
                        <div class="card-innr">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="view-bills">
                                    <div class="tile-header">
                                        <h6 class="tile-title">Active Employees In This Company</h6>
                                    </div>
                                    <div class="tile-data">
                                        <span
                                            class="tile-data-number">{{ number_format(0, 0) }}</span>

                                    </div>
                                    <div class="tile-footer">
                                        <div class="tile-link">
                                            <a href=""
                                                class="link link-bold link-ucap ">View Employees</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card height-auto">
                        <div class="card-innr">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="view-bills">
                                    <div class="tile-header">
                                        <h6 class="tile-title">Pay Groups In This Company</h6>
                                    </div>
                                    <div class="tile-data">
                                        <span
                                            class="tile-data-number">{{ number_format(0, 0) }}</span>

                                    </div>
                                    <div class="tile-footer">
                                        <div class="tile-link">
                                            <a href=""
                                                class="link link-bold link-ucap ">View Pay Groups</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-token height-auto">
                        <div class="card-innr">
                           <div class="tab-content">
                                <div class="tab-pane fade show active" id="view-vtpass">
                                    <div class="tile-header">
                                        <h6 class="card-sub-title">Current Salary Month For This Company</h6>
                                    </div>
                                    <div class="tile-data">
                                        <span class="tile-data-number"
                                            style="color:white">{{ date("F, Y") }}</span>

                                    </div>
                                    <div class="tile-footer">
                                        <div class="tile-link">
                                            <a href=""
                                                class="link link-bold link-ucap " style="color:white">View Payroll Summaries</a>
                                        </div>
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
        <div class="spinner">
            <span class="sp sp1"></span>
            <span class="sp sp2"></span>
            <span class="sp sp3"></span>
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

</body>

</html>


