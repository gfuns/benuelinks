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

    <style style="text/css">
        .stepper .step {
            width: 33%;
            text-align: center;
            position: relative;
        }

        .stepper .step::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1.5px;
            background: #e0e0e0;
            transform: translateY(-50%);
            z-index: 1;
        }


        /* Green when step is completed */
        .stepper .step.completed::before {
            background: #007bff;
            /* Green */
        }

        /* Green when step is completed */
        .stepper .step.active::before {
            background: #007bff;
            /* Green */
        }

        .stepper .step:first-child::before {
            width: 50%;
            left: 50%;
        }

        .stepper .step:last-child::before {
            width: 50%;
        }

        .stepper .step .circle {
            position: relative;
            z-index: 2;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #6c757d;
            margin: 0 auto 10px;
        }

        .stepper .step.active .circle,
        .stepper .step.completed .circle {
            background: #007bff;
            color: white;
        }

        .stepper .step.active .text,
        .stepper .step.completed .text {
            color: #007bff;
            font-weight: bold;
        }

        .text {
            font-size: 12px;
        }
    </style>
</head>

<body class="admin-dashboard page-user">
    @include('passenger.includes.nav')



    <div class="page-content">
        <div class="container">
            <h4><strong>Hi {{ Auth::user()->other_names }}, we just need few more details about you </strong></h4>

            <div class="card content-area">
                <div class="card-innr">
                    <div class="col-12 stepper d-flex " style="margin-bottom: 40px">
                        <div class="step completed">
                            <div class="circle">1</div>
                            <div class="text">Step 1</div>
                            <div class="text">Trip Selection</div>
                        </div>
                        <div class="step active">
                            <div class="circle">2</div>
                            <div class="text">Step 2</div>
                            <div class="text">Passenger Details</div>
                        </div>
                        <div class="step ">
                            <div class="circle">3</div>
                            <div class="text">Step 3</div>
                            <div class="text">Booking Summary</div>
                        </div>
                    </div>

                    <div class="row m-4">
                        <form class="validate-modern" action="{{ route('passenger.updatePassengerDetails') }}"
                            method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-item input-with-label">
                                        <label for="last-name" class="input-item-label">Last
                                            Name</label>
                                        <div class="input-wrap">
                                            <input class="input-bordered" type="text" id="last-name" name="last_name"
                                                required="required" placeholder="Enter Last Name" minlength="3"
                                                value="{{ Auth::user()->last_name }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-with-label">
                                        <label for="other-names" class="input-item-label">Other
                                            Names</label>
                                        <div class="input-wrap">
                                            <input class="input-bordered" type="text" id="other-names"
                                                name="other_names" placeholder="Enter Other Names" minlength="3"
                                                value="{{ Auth::user()->other_names }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-item input-with-label">
                                        <label for="mobile-number" class="input-item-label">Mobile
                                            Number</label>
                                        <div class="input-wrap">
                                            <input class="input-bordered" type="text" id="mobile-number"
                                                name="phone_number" placeholder="Enter Mobile Number"
                                                value="{{ Auth::user()->phone_number }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-item input-with-label">
                                        <label for="mobile-number" class="input-item-label">Gender</label>
                                        <div class="input-wrap">
                                            <select class="select-bordered select-block" name="gender" required
                                                id="gender" required="required">
                                                <option value="">Select Gender</option>
                                                <option value="male"
                                                    @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male
                                                </option>
                                                <option value="remale"
                                                    @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-item input-with-label">
                                        <label for="nok-name" class="input-item-label">Next Of Kin's
                                            Name</label>
                                        <div class="input-wrap">
                                            <input class="input-bordered" type="text" id="nok-name"
                                                name="nok_name" placeholder="Enter Next Of Kin's Name"
                                                value="{{ Auth::user()->nok }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-item input-with-label">
                                        <label for="nok-phone" class="input-item-label">Next Of Kin's
                                            Phone Number</label>
                                        <div class="input-wrap">
                                            <input class="input-bordered" type="text" id="nok-phone"
                                                name="nok_phone" placeholder="Enter Next Of Kin's Phone Number"
                                                value="{{ Auth::user()->nok_phone }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gaps-1x"></div>
                            <div class="">
                                <input id="myid" type="hidden" name="booking_id" value="{{ $booking->id }}"
                                    class="form-control" required>
                                <center>
                                    <button type="submit" class="btn btn-primary profile-update">Proceed &nbsp;<i
                                            class="fas fa-angle-right"></i></button>
                                </center>
                            </div>
                        </form>
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
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">1</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-2" name="seatnumber[]" type="checkbox"
                                                disabled="" /><label for="seat-2" class="disable-seat">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">2</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-3" name="seatnumber[]" type="checkbox"
                                                value="3" /><label for="seat-3" class="seat-three">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">3</h1>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-3">
                                            <input id="seat-4" name="seatnumber[]" type="checkbox"
                                                disabled="" /><label for="seat-4" class="disable-seat">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">4</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-5" name="seatnumber[]" type="checkbox"
                                                disabled="" /><label for="seat-5" class="disable-seat">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">5</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <input id="seat-6" name="seatnumber[]" type="checkbox"
                                                disabled="" /><label for="seat-6" class="disable-seat">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
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
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">7</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-8" name="seatnumber[]" type="checkbox"
                                                value="8" /><label for="seat-8" class="seat-eight">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">8</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <input id="seat-9" name="seatnumber[]" type="checkbox"
                                                value="9" /><label for="seat-9" class="seat-nine">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
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
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">10</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input id="seat-11" name="seatnumber[]" type="checkbox"
                                                value="11" /><label for="seat-11" class="seat-eleven">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
                                                    <h1 class="number">11</h1>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-3"></div>
                                        <div class="col-3">
                                            <input id="seat-12" name="seatnumber[]" type="checkbox"
                                                value="12" /><label for="seat-12" class="seat-twelve">
                                                <div class="seat-numbers">
                                                    <img src="{{ asset('images/seat.svg') }}" alt="" />
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
