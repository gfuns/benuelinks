<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Peace Mass Transit (PMT) | Booking</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-blue.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/seats.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style type="text/css">
        .vertical-text {
            writing-mode: vertical-rl;
            /* makes text vertical */
            transform: rotate(180deg);
            font-size:18px;
            /* flips it so it reads bottom to top */
        }
    </style>
</head>

<body class="admin-dashboard page-user">
    @include('passenger.includes.nav')



    <div class="page-content">
        <div class="container">
            <h4><strong>Online Vehicle Booking: </strong></h4>
            <div style="color: #253992; font-weight:bold; font-size: 15px; margin-top: 20px; margin-bottom: 20px">
                {{ $title }} &nbsp;<img src="{{ asset('images/separator.png') }}" style="height: 5px" />
                &nbsp;{{ $date }} </div>

            @foreach ($schedules as $schedule)
                <div class="card content-area">
                    <div class="card-innr">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ asset('images/fleet/1747067627.image 1.png') }}" class="" />
                            </div>
                            <div class="col-md-7">
                                <div style="color: #000; font-weight:bold; font-size: 24px;">
                                    <strong>Toyota (Hummer Bumper Bus)</strong>
                                </div>
                                <div class="mt-1" style="color: #000; font-size: 13px;"><strong><u>Departure:</u>
                                        {{ $schedule->departurePoint->terminal }} &nbsp;<img
                                            src="{{ asset('images/separator.png') }}" style="height: 5px" />
                                        &nbsp;<u>Destination:</u>
                                        {{ $schedule->destinationPoint->terminal }} </strong></div>
                                <div class="mt-1" style="color: #000; font-weight:bold; font-size: 14px;"><img
                                        src="{{ asset('images/carseat.svg') }}" style="height: 10px" />
                                    {{ $schedule->availableSeats() }} Seats
                                    (Available)
                                    <span style="margin-left: 20px"><i class="far fa-clock"></i>
                                        {{ $schedule->scheduled_time }}</span>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div style="color: #253992; font-weight:bold; font-size: 24px;">
                                    <strong>&#8358;{{ number_format($schedule->transportFare(), 2) }}</strong>
                                </div>
                                <div style="color: #253992; font-weight:bold; font-size: 12px;">Cash Back:
                                    &#8358;{{ number_format(0, 2) }}</div>
                                <div><button class="btn btn-primary btn-sm w-100" data-toggle="modal"
                                        data-target="#viewSeats" data-backdrop="static" data-myid="{{ $schedule->id }}"
                                        data-vehicletype="{{ $schedule->getvehicleType() }}">View Seats</button></div>
                            </div>
                        </div>


                    </div>

                </div>
            @endforeach

            @if (count($schedules) < 1)
                <div class="card content-area">
                    <div class="card-innr">
                        <tr>
                            <td colspan="6">
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="far fa-sad-tear"
                                            style="font-size: 48px"></i>
                                        <h5 class="mt-2">No Trip Schedule Found For Your Query</h5>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </div>
                </div>
            @endif
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
                                        <div class="col-6">
                                            <img src="{{ asset('images/steering-wheel.svg') }}" alt=""
                                                style="width: 40px" />
                                        </div>
                                        <div class="col-3 ">
                                            <input id="seat-1" name="seatnumber[]" type="checkbox"
                                                value="1" /><label for="seat-1" class="seat-one">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">1</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-2" name="seatnumber[]" type="checkbox"
                                                value="2" /><label for="seat-2" class="seat-two">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}"
                                                        alt=""style="max-width: 40px !important" />
                                                    <h1 class="number">2</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-3" name="seatnumber[]" type="checkbox"
                                                value="3" /><label for="seat-3" class="seat-three">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">3</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-4" name="seatnumber[]" type="checkbox"
                                                value="4" /><label for="seat-4" class="seat-four">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">4</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-5" name="seatnumber[]" type="checkbox"
                                                value="5" /><label for="seat-5" class="seat-five">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">5</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-6" name="seatnumber[]" type="checkbox"
                                                value="6" /><label for="seat-6" class="seat-six">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">6</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <br /> --}}
                                    <div class="row">
                                        <div class="col-3">
                                             <div class="mb-2">&nbsp;</div>
                                            <input id="seat-7" name="seatnumber[]" type="checkbox"
                                                value="7" /><label for="seat-7" class="seat-seven">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">7</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-2">&nbsp;</div>
                                            <input id="seat-8" name="seatnumber[]" type="checkbox"
                                                value="8" /><label for="seat-8" class="seat-eight">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">8</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3 vertical-text"><strong>Road</strong></div>
                                        <div class="col-3">
                                            <div class="mb-2" style="font-size: 18px"><strong>Road</strong></div>
                                            <input id="seat-9" name="seatnumber[]" type="checkbox"
                                                value="9" /><label for="seat-9" class="seat-nine">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
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
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">10</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-11" name="seatnumber[]" type="checkbox"
                                                value="11" /><label for="seat-11" class="seat-eleven">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">11</h1>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="col-3 vertical-text"><strong>Road</strong></div>
                                        <div class="col-3">
                                            <input id="seat-12" name="seatnumber[]" type="checkbox"
                                                value="12" /><label for="seat-12" class="seat-twelve">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">12</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-13" name="seatnumber[]" type="checkbox"
                                                value="13" /><label for="seat-13" class="seat-thirteen">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">13</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-14" name="seatnumber[]" type="checkbox"
                                                value="14" /><label for="seat-14" class="seat-fourten">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">14</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-15" name="seatnumber[]" type="checkbox"
                                                value="15" /><label for="seat-15" class="seat-fifteen">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">15</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-16" name="seatnumber[]" type="checkbox"
                                                value="16" /><label for="seat-16" class="seat-sixteen">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt=""
                                                        style="max-width: 40px !important" />
                                                    <h1 class="number">16</h1>
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
