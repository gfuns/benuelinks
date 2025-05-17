<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Peace Mass Transit (PMT) | Booking History</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-blue.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

        <style type="text/css">
            .nobreak {
                white-space: nowrap;
            }
        </style>
</head>

<body class="admin-dashboard page-user">
    @include('passenger.includes.nav')



    <div class="page-content">
        <div class="container">
            <div class="card content-area">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title">
                            Booking History
                        </h4>
                    </div>

                    <div class="page-nav-wrap">
                        <div class="search-adv-wrap">
                            <form class="adv-search" id="adv-search" action="" method="GET" autocomplete="off">
                                <div class="adv-search">
                                    <div class="row align-items-end guttar-20px guttar-vr-15px">
                                        <div class="col-sm-4 col-lg-3 col-mb-6">
                                            <div class="input-wrap input-with-label">
                                                <label class="input-item-label input-item-label-s2 text-exlight">Start
                                                    Date</label>
                                                <input class="input-solid input-solid-sm input-transparent"
                                                    type="date" placeholder="Start Date" name="start_date"
                                                    style="border: 1.5px solid #e0e8f3;" required
                                                    value="{{ $startDate }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-3 col-mb-6">
                                            <div class="input-wrap input-with-label">
                                                <label class="input-item-label input-item-label-s2 text-exlight">End
                                                    Date</label>
                                                <input class="input-solid input-solid-sm input-transparent"
                                                    type="date" placeholder="End Date" name="end_date"
                                                    style="border: 1.5px solid #e0e8f3;" required
                                                    value="{{ $endDate }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-2 col-mb-6">
                                            <div class="input-wrap">
                                                <input type="hidden" name="filter" value="advanced">
                                                <button class="btn btn-sm btn-sm-s2 btn-auto btn-primary">
                                                    <em class="ti ti-search width-auto"></em><span>Filter Records</span>
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
                                        class="search-count">{{ number_format(count($bookingHistory), 0) }}</span>
                                    Record(s) using your query.
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="data-table dt-filter-init user-list nobreak">
                            <thead>
                                <tr class="data-item data-head">
                                    <th class="data-col">S/No.</th>
                                    <th class="data-col">Booking Number</th>
                                    <th class="data-col">Travel Route</th>
                                    <th class="data-col">Travel Date/Time</th>
                                    <th class="data-col">Fare Paid</th>
                                    <th class="data-col">Trip Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($bookingHistory as $bk)
                                    <tr class="data-item">
                                        <td class="data-col">
                                            <span class="sub sub-s2 sub-email">{{ $loop->index + 1 }}</span>
                                        </td>
                                        <td class="data-col">
                                            <span class="sub sub-s2 sub-email">{{ $bk->booking_number }}</span>
                                        </td>
                                        <td class="data-col">
                                            <span class="sub sub-s2 sub-email">{{ $bk->travelRoute() }}</span>
                                        </td>
                                        <td class="data-col">
                                            <span
                                                class="sub sub-s2 sub-email">{{ date_format(new DateTime($bk->travel_date), 'l - jS M, Y') }}
                                                {{ $bk->departure_time }}</span>
                                        </td>
                                        <td class="data-col">
                                            <span
                                                class="sub sub-s2 sub-email">&#8358;{{ number_format($bk->travel_fare, 2) }}</span>
                                        </td>
                                        <td class="data-col">
                                            @if ($bk->tripStatus() == 'trip successful')
                                                <span
                                                    class="dt-status-md badge badge-outline badge-md badge-success text-success"><strong>Trip
                                                        Successful</strong></span>
                                            @elseif ($bk->tripStatus() == 'in transit')
                                                <span
                                                    class="dt-status-md badge badge-outline badge-md badge-primary text-primary"><strong>In
                                                        Transit</strong></span>
                                            @else
                                                <span
                                                    class="dt-status-md badge badge-outline badge-md badge-warning"><strong>Awaiting
                                                        Boarding</strong></span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($bookingHistory) < 1)
                                    <tr>
                                        <td colspan="7">
                                            <div class="col-xl-12 col-12 job-items job-empty">
                                                <div class="text-center mt-4"><i class="far fa-sad-tear"
                                                        style="font-size: 48px"></i>
                                                    <h5 class="mt-2">No Booking Records Found</h5>
                                                </div>
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
        document.getElementById("history").classList.add('active');
    </script>

</body>

</html>
