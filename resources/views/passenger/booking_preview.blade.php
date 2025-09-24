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
            <h4><strong>Booking Summary and Preview </strong></h4>

            <div class="card content-area">
                <div class="card-innr">

                    <div class="col-12 stepper d-flex " style="margin-bottom: 40px">
                        <div class="step completed">
                            <div class="circle">1</div>
                            <div class="text">Step 1</div>
                            <div class="text">Trip Selection</div>
                        </div>
                        <div class="step completed">
                            <div class="circle">2</div>
                            <div class="text">Step 2</div>
                            <div class="text">Passenger Details</div>
                        </div>
                        <div class="step active">
                            <div class="circle">3</div>
                            <div class="text">Step 3</div>
                            <div class="text">Booking Summary</div>
                        </div>
                    </div>

                    <div class="row m-4">

                        <div class="row">
                            <div class="col-md-6 order-2 order-lg-2">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class=""><strong>Take-off Point</strong></td>
                                            <td class="">{{ $booking->departurePoint->terminal }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Destination</strong></td>
                                            <td class="">{{ $booking->destinationPoint->terminal }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Travel Date</strong></td>
                                            <td class="">
                                                {{ date_format(new DateTime($booking->travel_date), 'l - jS M, Y') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Departure Time</strong></td>
                                            <td class="">{{ $booking->departure_time }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Seat Number</strong></td>
                                            <td class="">Seat {{ $booking->seat }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Travel Fare</strong></td>
                                            <td class="">&#8358;{{ number_format($booking->travel_fare, 2) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Cash Back</strong></td>
                                            <td class="">&#8358;{{ number_format(0, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Total Amount</strong></td>
                                            <td class="">&#8358;{{ number_format($booking->travel_fare, 2) }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <div class="mt-4">
                                    <form method="POST" action="{{ route("passenger.payWithXtrapay") }}">
                                        @csrf
                                        <input id="myid" type="hidden" name="booking_id"
                                            value="{{ $booking->id }}" class="form-control" required>


                                        <div class="row d-flex justify-content-between">
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-primary profile-update">Proceed To Payment
                                                    &nbsp;<i class="fas fa-credit-card"></i></button>
                                            </div>

                                            <div>
                                                @if ($accountBalance >= $booking->travel_fare)
                                                    <a href="{{ route("passenger.payWithWallet", [$booking->id]) }}" onclick="return disableAfterClick(this);"><button type="button" class="btn btn-primary profile-update">Pay Using Wallet
                                                        &nbsp;<i class="fas fa-wallet"></i></button></a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6 order-1 order-lg-2 mb-4">
                                <h4>Terms and Conditions</h4>
                                <p>Please Note that Peace Mass Transit (PMT) does not have a refund policy, however
                                    our tickets are valid for a period of 30 days from the day of purchase. </p>
                                <p>By proceeding to make payment, you agree to the Terms and Conditions of Peace
                                    Mass Transit (PMT).</p>
                            </div>

                        </div>
                        <div class="gaps-1x"></div>

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
        document.getElementById("dashboard").classList.add('active');

        function disableAfterClick(link) {
            if (link.classList.contains('clicked')) {
                return false; // Stop multiple clicks
            }
            link.classList.add('clicked'); // Mark as clicked
            link.innerHTML = "Submitting request, please wait...";
            link.style.pointerEvents = "none"; // Prevent further clicks (optional)
            link.style.opacity = "0.6"; // Optional: make it look disabled
            return true; // Allow the link to follow the href
        }
    </script>


</body>

</html>
