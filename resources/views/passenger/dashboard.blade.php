<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Peace Mass Transit (PMT) | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-blue.css') }}?ver={{ date('his') }}">

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
            <h4><strong>Welcome Back {{ Auth::user()->last_name }}, {{ Auth::user()->other_names }}: </strong></h4>
            <div style="color: #253992; font-weight:bold; font-size: 15px; margin-top: 40px">Where would you like to
                travel to next?</div>
            <div>
                <div class="page-nav-wrap">

                    <div class="search-adv-wrap" style="background: #fff; border: 1px solid #fff">
                        <form class="adv-search" id="adv-search" action="" method="GET" autocomplete="off">
                            <div class="adv-search">
                                <div class="row align-items-end guttar-20px guttar-vr-15px">
                                    <div class="col-sm-4 col-lg-3 col-mb-6">
                                        <div class="input-wrap input-with-label">
                                            <label class="input-item-label input-item-label-s2" style="color:black">Take
                                                Off Point</label>
                                            <select name="takeoff" class="select select-sm select-block select-bordered"
                                                data-dd-class="search-on" required>
                                                <option value="">All Terminals</option>
                                                @foreach ($companyTerminals as $rt)
                                                    <option value="{{ $rt->id }}">
                                                        {{ $rt->terminal }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-lg-3 col-mb-6">
                                        <div class="input-wrap input-with-label" style="color:black">
                                            <label class="input-item-label input-item-label-s2">Destination</label>
                                            <select name="destination"
                                                class="select select-sm select-block select-bordered"
                                                data-dd-class="search-on" required>
                                                <option value="">All Terminals</option>
                                                @foreach ($companyTerminals as $rd)
                                                    <option value="{{ $rd->id }}">
                                                        {{ $rd->terminal }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-lg-3 col-mb-6">
                                        <div class="input-wrap input-with-label">
                                            <label class="input-item-label input-item-label-s2"
                                                style="color:black">Departure Date</label>
                                            <input class="input-solid input-solid-sm input-transparent" type="date"
                                                placeholder="Departure Date" name="departure_date" required
                                                min="{{ date('Y-m-d') }}" style="border: 1.5px solid #e0e8f3;">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-lg-2 col-mb-6">
                                        <div class="input-wrap">
                                            <input type="hidden" name="filter" value="advanced">
                                            <button class="btn btn-sm btn-sm-s2 btn-auto btn-primary">
                                                <em class="ti ti-search width-auto"></em><span>Search Trips</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>


                <div class="card content-area">
                    <div class="card-innr">
                        <div class="card-head has-aside">
                            <h4 class="card-title">
                                Scheduled Trips
                            </h4>
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="data-table nobreak user-list nobreak">
                                <thead>
                                    <tr class="data-item data-head">
                                        <th class="data-col">S/No.</th>
                                        <th class="data-col">Schedule</th>
                                        <th class="data-col">Departure Date/Time</th>
                                        <th class="data-col">Travel Fare</th>
                                        <th class="data-col">Available Seats</th>
                                        <th class="data-col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr class="data-item">
                                            <td class="data-col">
                                                <span class="sub sub-s2 sub-email">{{ $loop->index + 1 }}</span>
                                            </td>
                                            <td class="data-col">
                                                <span
                                                    class="sub sub-s2 sub-email">{{ $schedule->travelRoute() }}</span>
                                            </td>
                                            <td class="data-col">
                                                <span class="sub sub-s2 sub-email">
                                                    {{ date_format(new DateTime($schedule->scheduled_date), 'l - jS M, Y') }}
                                                    {{ $schedule->scheduled_time }}</span>
                                            </td>
                                            <td class="data-col">
                                                <span
                                                    class="sub sub-s2 sub-email">&#8358;{{ number_format($schedule->transportFare(), 2) }}</span>
                                            </td>
                                            <td class="data-col">
                                                <span class="sub sub-s2 sub-email">{{ $schedule->availableSeats() }}
                                                    Available Seats</span>
                                            </td>
                                            <td class="data-col dt-status data-col-wd-md text-right">
                                                <a href="">
                                                    <span
                                                        class="dt-status-md badge badge-outline badge-md badge-primary text-primary"><strong>Book
                                                            Trip</strong></span>
                                                </a>
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



</body>

</html>
