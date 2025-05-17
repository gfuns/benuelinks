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
    <link rel="stylesheet" href="{{ asset('assets/css/seats.css') }}?ver={{ date('his') }}">

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
                        <form class="adv-search" id="adv-search" action="{{ route('passenger.searchSchedule') }}"
                            method="POST" autocomplete="off">
                            @csrf
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
                            <table class="data-table dt-filter-init nobreak user-list nobreak">
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
                                                <span
                                                    class="badge badge-outline badge-md badge-primary text-primary"
                                                    data-toggle="modal" data-target="#viewSeats" data-backdrop="static"
                                                    data-myid="{{ $schedule->id }}"
                                                    data-vehicletype="{{ $schedule->getvehicleType() }}"
                                                    style="cursor: pointer"><strong>Book Trip</strong></span>
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


    <div class="modal fade" id="viewSeats" tabindex="-1">
        <div class="modal-dialog modal-dialog-sm" style="margin-top:150px">
            <div class="modal-content">
                <a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em
                        class="ti ti-close"></em></a>
                <div class="popup-body">
                    <h3 class="popup-title">Select Seat</h3>
                    <form method="POST" action="{{ route('passenger.seatSelection') }}">
                        @csrf
                        <div class="seats-select pt-2 pb-2">
                            <div class="row text-center">
                                <div class="col-4">
                                    <h1 class="titles-seat">
                                        <img src="{{ asset('images/selected.svg') }}" alt="" /><br />
                                        Selected Seat
                                    </h1>
                                </div>
                                <div class="col-4">
                                    <h1 class="titles-seat">
                                        <img src="{{ asset('images/available.svg') }}" alt="" />
                                        <br />Available Seat
                                    </h1>
                                </div>
                                <div class="col-4">
                                    <h1 class="titles-seat">
                                        <img src="{{ asset('images/booked.svg') }}" alt="" /> <br />Booked
                                        Seat
                                    </h1>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-sm-12 col-md-10 offset-md-1">
                                    <div class="row">
                                        <div class="col-9">
                                            <img src="{{ asset('images/steering-wheel.svg') }}" alt=""
                                                style="width: 40px" />
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <input id="seat-1" name="seatnumber[]" type="checkbox"
                                                value="1" /><label for="seat-1" class="seat-one">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">1</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-2" name="seatnumber[]" type="checkbox" value="2" /><label
                                                for="seat-2" class="seat-two">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">2</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-3" name="seatnumber[]" type="checkbox"
                                                value="3" /><label for="seat-3" class="seat-three">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">3</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-4" name="seatnumber[]" type="checkbox" value="4" /><label
                                                for="seat-4" class="seat-four">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">4</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-5" name="seatnumber[]" type="checkbox" value="5" /><label
                                                for="seat-5" class="seat-five">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">5</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <input id="seat-6" name="seatnumber[]" type="checkbox" value="6" /><label
                                                for="seat-6" class="seat-six">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">6</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-7" name="seatnumber[]" type="checkbox"
                                                value="7" /><label for="seat-7" class="seat-seven">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">7</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-8" name="seatnumber[]" type="checkbox"
                                                value="8" /><label for="seat-8" class="seat-eight">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">8</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <input id="seat-9" name="seatnumber[]" type="checkbox"
                                                value="9" /><label for="seat-9" class="seat-nine">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">9</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-10" name="seatnumber[]" type="checkbox"
                                                value="10" /><label for="seat-10" class="seat-ten">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">10</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-11" name="seatnumber[]" type="checkbox"
                                                value="11" /><label for="seat-11" class="seat-eleven">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">11</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <input id="seat-12" name="seatnumber[]" type="checkbox"
                                                value="12" /><label for="seat-12" class="seat-twelve">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" style="max-width: 40px !important"/>
                                                    <h1 class="number">12</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <input id="myid" type="hidden" name="schedule_id" class="form-control"
                                            required>
                                        <input id="vehicletype" type="hidden" name="vehicle_type"
                                            class="form-control" required>
                                        <div class="col-md-12">
                                            <button id="submitBtn" type="submit"
                                                class="btn btn-primary btn-sm w-100" disabled="">
                                                Continue
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


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
        document.getElementById("dashboard").classList.add('active');

           // Wait for the DOM to load
           document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="seatnumber[]"]');
            const submitBtn = document.getElementById('submitBtn');

            // Add change event to each checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    // Check if at least one checkbox is checked
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    submitBtn.disabled = !anyChecked;
                });
            });
        });
    </script>

</body>

</html>
