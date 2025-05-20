<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peace Mass Transit (PMT) - Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/seats.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
        body {
            overflow-x: hidden;
        }

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
            width: 25px;
            height: 25px;
            line-height: 25px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #6c757d;
            margin: 0 auto 10px;
            font-size: 12px;
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
            font-size: 10px;
        }

        .busSection {
            padding-top: 130px;
        }

        .containerss {
            width: 800px;
            align-content: center;
        }

        .content-area {
            border-radius: 30px;
            /* border:none; */
        }

        .inner-card {
            border-radius: 30px;
        }

        .newsletter-section {
            /* background: #f9f9f9; */
            padding: 3rem 1rem;
            text-align: center;
            margin: 30px 150px 50px 150px;
        }

        .cstnavbar {
            margin-left: 150px;
        }

        .nav-item {
            margin-left: 20px;
            font-weight: bold;
        }

        .nav-item .active {
            color: #6A6DFD !important;
            /* text-decoration: underline */
        }

        .cstgfunsBtn {
            background: #6A6DFD;
            border: #6A6DFD;
        }

        .socialicon {
            height: 30px;
        }

        .footer {
            height: 160px;
            margin: 0px 150px;
            border-top: 1px solid #ccc;
            padding: 0px;
        }

        .footer-content {
            margin-top: 30px;
        }

        .footer-links {
            text-decoration: none;
            color: black;
        }


        .cstLetter {
            padding: 0px 200px;
        }

        .letter-bg {
            background: url('/images/newsletter.png') no-repeat center center/cover;
            height: 14vh;
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }

        .letter-bg h5 {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.7rem;
            font-weight: bold;
            color: #6A6DFD;
            width: 100%;
        }

        .socials {
            text-align: right;
        }

        .input-group .btn {
            margin-left: 40px;
            /* Adjust spacing as needed */
        }

        .bussearch {
            height: 580px;
            bottom: 50%;
        }

        .seatBtn {
            background: #6A6DFD;
            border: #6A6DFD;
        }

        .text-height {
            height: 45px;
        }


        @media (max-width: 575px) {
            .cstnavbar {
                margin-left: 0px;
            }

            .nav-item {
                margin-left: 0px;
            }


            .navbar-nav .nav-item {
                margin-top: 7px;
            }

            /* .busSection {
                padding-top: 110px;
                padding-bottom: 0px;
                padding-left: 20px;
                padding-right: 20px;
            } */


            .newsletter-section {
                padding: 3rem 1rem;
                text-align: center;
                margin: 30px 30px 50px 30px;
            }

            .cstLetter {
                padding: 0px;
            }

            .letter-bg {
                background: url('/images/newsletter.png') no-repeat center center/cover;
                height: 6vh;
                position: relative;
                text-align: center;
                margin-bottom: 20px;
            }


            .letter-bg h5 {
                transform: translate(-50%, -50%);
                font-size: 1.2rem;
            }

            .footer {
                margin: 0px;
                text-align: center;
            }

            .socials {
                text-align: center;
            }

            .pageheading {
                font-size: 15px;
            }

            .text-height {
                height: 45px;
            }

            .fs14 {
                font-size: 14px;
            }

        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="{{ asset('images/logo.png') }}" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav cstnavbar">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hire a Bus</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
                <a href="/login"
                    class="cstgfunsBtn btn btn-primary cstLoginBtn rounded-pill ms-auto mt-md-0 mt-4 mb-md-0 mb-4">Sign
                    Up /
                    Login</a>
            </div>
        </div>
    </nav>




    <section class="busSection bg-light">
        <div class="col-12 col-md-7 mx-auto">
            <h5 class="pageheading text-center"><strong>Booking Summary and Preview </strong></h5>
            <div class="col-12 stepper d-flex" style="margin-top: 20px; margin-bottom: 40px">
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
                <div class="card content-area pt-3 pb-3 ps-4 pe-4 pt-md-5 pb-md-5 ps-md-5 pe-md-5 mb-5">
                    <div class="">
                        <table class="table">
                            <tbody class="fs14">
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
                        <div class="mt-5 fs14">
                            <h4>Terms and Conditions</h4>
                            <p>Please Note that Peace Mass Transit (PMT) does not have a refund policy, however
                                our tickets are valid for a period of 30 days from the day of purchase. </p>
                            <p>By proceeding to make payment, you agree to the Terms and Conditions of Peace
                                Mass Transit (PMT).</p>

                        </div>

                        <div class="mt-4">
                            <form method="POST" action="{{ route('guest.payWithCard') }}">
                                @csrf
                                <input id="myid" type="hidden" name="booking_id" value="{{ $booking->id }}"
                                    class="form-control" required>


                                <div class="row d-flex text-center">
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-primary seatBtn">Proceed To
                                            Payment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Newsletter -->
    <section class="newsletter-section">
        <div class="cstLetter">
            <div class="letter-bg">
                <h5>SUBSCRIBE TO OUR NEWSLETTER</h5>
            </div>
            <p>Sign up for our newsletter and receive exclusive travel deals, insider tips, and destination
                inspiration. Don't miss out on the adventure - join our mailing list today!</p>
            <div class="d-flex justify-content-center mt-4">
                <div class="position-relative w-100 w-md-50">
                    <form method="POST" action="{{ route('newsletter.subscribe') }}">
                        @csrf
                        <input type="email" name="email" class="form-control pe-5" required
                            placeholder="Enter your email address here..." style="height: 50px">
                        <button class="btn btn-primary position-absolute end-0 top-0 mt-2 me-3 mb-2 px-3 py-1">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>


        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 footer">
        <div class="container">
            <div class="row footer-content">
                <div class="col-12 col-md-2 mb-3"><img src="{{ asset('images/logo.png') }}" /></div>
                <div class="col-12 col-md-8 mb-3">
                    <div class="d-none d-md-block">
                        <div class="d-flex gap-5 ms-5">
                            <a href="#" class="footer-links">Destinations</a>
                            <a href="#" class="footer-links">Hire a Bus</a>
                            <a href="#" class="footer-links">Tours</a>
                            <a href="/about" class="footer-links">About</a>
                            <a href="#" class="footer-links">Blog</a>
                            <a href="#" class="footer-links">Contact</a>
                        </div>
                    </div>
                    <div class="d-block d-sm-none">
                        <div class="row col-12 mb-3">
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Destinations</a></div>
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Hire a Bus</a></div>
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Tours</a></div>
                            <div class="col-6 col-md-2"><a href="/about" class="footer-links">About</a></div>
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Blog</a></div>
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Contact</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-2 socials mb-3">
                    <a href="#"><img class="socialicon me-3" src="{{ asset('images/facebook.png') }}" /></a>
                    <a href="#"><img class="socialicon me-3" src="{{ asset('images/twitter.png') }}" /></a>
                    <a href="#"><img class="socialicon" src="{{ asset('images/Instagram.png') }}" /></a>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="{{ asset('assets/js/seats.js') }}?ver={{ date('his') }}"></script>

    @include('sweetalert::alert')


</body>

</html>
