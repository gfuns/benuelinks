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

        .busSection {
            padding-top: 130px;
            /* padding-bottom: 100px; */
            padding-left: 75px;
        }

        .content-area {
            padding: 30px;
            /* border:none; */
        }

        .newsletter-section {
            /* background: #f9f9f9; */
            padding: 3rem 1rem;
            text-align: center;
            margin: 100px 150px 50px 150px;
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

        .vertical-text {
            writing-mode: vertical-rl;
            /* makes text vertical */
            transform: rotate(180deg);
            font-size:15px;
            /* flips it so it reads bottom to top */
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

            .busSection {
                padding-top: 110px;
                padding-bottom: 0px;
                padding-left: 20px;
                padding-right: 20px;
            }


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

        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="https://pmt.gabrielnwankwo.com"><img src="{{ asset('images/logo.png') }}" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav cstnavbar">
                    <li class="nav-item"><a class="nav-link" href="https://pmt.gabrielnwankwo.com">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hire a Bus</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://pmt.gabrielnwankwo.com/about-us">About Us</a></li>
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
        <div class="containersss">
            <h4><strong>Online Vehicle Booking: </strong></h4>
            <div style="color: #253992; font-weight:bold; font-size: 15px; margin-top: 20px; margin-bottom: 20px">
                {{ $title }} &nbsp;<img src="{{ asset('images/separator.png') }}" style="height: 5px" />
                &nbsp;{{ $date }} </div>
            <div class="row" style="background: url('/images/PerspectiveGrid.png') bottom center no-repeat; ">
                <div class="col-12 col-md-7">

                    @foreach ($schedules as $schedule)
                        <div class="card content-area mb-5">
                            <div class="card-innr">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="{{ asset('images/fleet/1747067627.image 1.png') }}" class="" />
                                    </div>
                                    <div class="col-md-6">
                                        <div style="color: #000; font-weight:bold; font-size: 20px;">
                                            <strong>KINGLONG BUS</strong>
                                        </div>
                                        <div class="mt-3" style="color: #000; font-size: 12px;">
                                            <strong><u>Departure:</u>
                                                {{ $schedule->departurePoint->terminal }} &nbsp;<img
                                                    src="{{ asset('images/separator.png') }}" style="height: 5px" />
                                                &nbsp;<u>Destination:</u>
                                                {{ $schedule->destinationPoint->terminal }} </strong>
                                        </div>
                                        <div class="mt-3" style="color: #000; font-weight:bold; font-size: 14px;"><img
                                                src="{{ asset('images/carseat.svg') }}" style="height: 10px" />
                                            {{ $schedule->availableSeats() }} Seats
                                            (Available)
                                            <span style="margin-left: 20px"><i class="far fa-clock"></i>
                                                {{ $schedule->scheduled_time }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <div style="color: #253992; font-weight:bold; font-size: 24px;">
                                            <strong>&#8358;{{ number_format($schedule->transportFare(), 2) }}</strong>
                                        </div>
                                        <div style="color: #253992; font-weight:bold; font-size: 12px;">Cash Back:
                                            &#8358;{{ number_format(0, 2) }}</div>
                                        <div><button class="btn btn-primary btn-sm w-100 seatBtn" data-bs-toggle="modal"
                                                data-bs-target="#viewSeats" data-backdrop="static"
                                                data-myid="{{ $schedule->id }}"
                                                data-vehicletype="{{ $schedule->getvehicleType() }}">View
                                                Seats</button></div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    @endforeach

                    @if (count($schedules) < 1)
                        <div class="mt-5">
                            <tr>
                                <td colspan="6">
                                    <div class="col-xl-12 col-12">
                                        <div class="mt-4">
                                            {{-- <i class="far fa-sad-tear" style="font-size: 48px"></i> --}}
                                            <h5 class="mt-2">No Trip Schedule Found For Your Query</h5>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </div>
                    @endif
                </div>

                {{-- @if (count($schedules) > 1) --}}
                <div class="col-12 col-md-5 d-none d-md-block">
                    <img class="bussearch" src="{{ asset('images/bussearch.png') }}" class="img-fluid w-100" />
                </div>
                {{-- @endif --}}

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
                    <form method="GET" action="{{ route('newsletter.subscribe') }}">
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
                            <a href="https://pmt.gabrielnwankwo.com/about-us" class="footer-links">About</a>
                            <a href="#" class="footer-links">Blog</a>
                            <a href="#" class="footer-links">Contact</a>
                        </div>
                    </div>
                    <div class="d-block d-sm-none">
                        <div class="row col-12 mb-3">
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Destinations</a></div>
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Hire a Bus</a></div>
                            <div class="col-6 col-md-2"><a href="#" class="footer-links">Tours</a></div>
                            <div class="col-6 col-md-2"><a href="https://pmt.gabrielnwankwo.com/about" class="footer-links">About</a></div>
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



    <div class="modal fade" id="viewSeats" tabindex="-1">
        <div class="modal-dialog modal-dialog-sm" style="margin-top:150px">
            <div class="modal-content">
                <div class="modal-header" style="border:none">
                    <h5 class="modal-title ms-4">Select Seat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('guest.seatSelection') }}">
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
                                             <div class="mb-3">&nbsp;</div>
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
                                            <div class="mb-3">&nbsp;</div>
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
                                            <div class="mb-3 mt-2" style="font-size: 14px"><strong>Road</strong></div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="{{ asset('assets/js/seats.js') }}?ver={{ date('his') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
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
