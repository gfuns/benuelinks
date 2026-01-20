<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env("APP_NAME")}} - About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('images/bg.png') no-repeat center center/cover;
            height: 102vh;
            color: white;
            position: relative;
            text-align: center;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Dark overlay */
        }

        .hero-section h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 5rem;
            font-weight: bold;
        }

        .video-card {
            background: url('images/howitworks.png') center center/cover no-repeat;
            position: relative;
            border-radius: 1.5rem;
            overflow: hidden;
            /* padding-top: 56.25%; */
            height: 500px;
            /* 16:9 aspect ratio */
        }

        .video-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
        }

        .video-card-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            z-index: 1;
        }

        .video-card .play-btn {
            position: absolute;
            bottom: 5rem;
            right: 6rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
        }

        .btnplay {
            height: 120px;
        }

        .cstContact {
            margin: 50px 150px;
        }

        .cstContact h1 {
            font-size: 48px;
            font-weight: bolder;
        }

        .contactheading {
            color: #6A6DFD;
            display: block;
        }

        .video-card-content h1 {
            font-size: 84px;
            margin-top: 210px;
        }

        .video-card-content h3 {
            font-size: 24px;
        }

        .workdiv {
            height: 120px;
        }

        .workimg {
            height: 120px;
        }

        .icon-box {
            text-align: center;
            padding: 2rem 1rem;
        }

        .icon-box i {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .map-container {
            height: 300px;
            background-color: #eee;
            margin-top: 50px;
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

        .cstIntro {
            padding: 330px;
            font-size: 19px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .cstBenefits {
            border-radius: 37.5px;
            background: #F2F2F2;
            margin: 0px 150px;
            height: 300px;
            margin-bottom: 150px;
            padding: 10px;
        }

        .subbenefit {
            color: #4E4E4E;
            font-size: 14px;
        }

        .subicon {
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .cstVideo {
            margin: 0px 150px;
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
            background: url('images/newsletter.png') no-repeat center center/cover;
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


        @media (max-width: 575px) {
            .cstnavbar {
                margin-left: 0px;
            }

            .nav-item {
                margin-left: 0px;
            }

            .hero-section h1 {
                font-size: 2.3rem;
            }

            .cstIntro {
                padding: 30px;
                font-size: 16px;
            }

            .cstBenefits {
                margin: 0px 30px;
                height: auto;
                margin-bottom: 50px;
            }

            .cstVideo {
                margin: 0px 30px;
            }

            .workdiv {
                height: 75px;
            }

            .workimg {
                height: 75px;
            }

            .video-card {
                width: 100%;
                height: auto;
                aspect-ratio: 16 / 9;
            }

            .video-card .play-btn {
                bottom: 0.5rem;
                right: 0.5rem;
            }

            .btnplay {
                height: 40px;
            }

            .video-card-content h1 {
                font-size: 28px;
                margin-top: 35px;
            }

            .video-card-content h3 {
                font-size: 12px;
            }

            .navbar-nav .nav-item {
                margin-top: 7px;
            }


            .cstContact {
                margin: 0px 30px;
            }

            .cstContact h1 {
                font-size: 24px;
            }

            .newsletter-section {
                padding: 3rem 1rem;
                text-align: center;
                margin: 100px 30px 50px 30px;
            }

            .cstLetter {
                padding: 0px;
            }

            .letter-bg {
                background: url('images/newsletter.png') no-repeat center center/cover;
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
            <a class="navbar-brand" href="/"><img src="{{ asset('images/logo.png') }}"  style="max-height:50px"/></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav cstnavbar">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hire a Bus</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
                <a href="/login"
                    class="cstgfunsBtn btn btn-primary cstLoginBtn rounded-pill ms-auto mt-md-0 mt-4 mb-md-0 mb-4">Sign
                    Up /
                    Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1>ABOUT US</h1>
    </section>

    <!-- Company Overview -->
    <section class="py-5 text-center cstIntro">
        <div class="container">
            <p>Peace Mass Transit (PMT) is a leading Nigerian transportation company known for its extensive intercity
                network, affordable fares, and commitment to safety and customer satisfaction, offering convenient
                online booking options and a wide range of routes.</p>
        </div>
    </section>

    <!-- Features -->
    <section class="cstBenefits">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 icon-box">
                    <img class="subicon" src="{{ asset('images/delight.png') }}" />
                    <h6>Customer Delight</h6>
                    <p class="subbenefit">We deliver the best service and experience for our customer.</p>
                </div>
                <div class="col-md-3 icon-box">
                    <img class="subicon" src="{{ asset('images/adventure.png') }}" />
                    <h6>Authentic Adventure</h6>
                    <p class="subbenefit">We deliver the real adventure experience for our customer.</p>
                </div>
                <div class="col-md-3 icon-box">
                    <img class="subicon" src="{{ asset('images/guides.png') }}" />
                    <h6>Expert Guides</h6>
                    <p class="subbenefit">We deliver only expert tour guides for our customer.</p>
                </div>
                <div class="col-md-3 icon-box">
                    <img class="subicon" src="{{ asset('images/time.png') }}" />
                    <h6>Time Flexibility</h6>
                    <p class="subbenefit">We welcome time flexibility of traveling for our customer.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="cstVideo">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-start gap-4">
                <div class="d-flex flex-row flex-md-column">
                    <div class="workdiv">
                        <img class="workimg" src="{{ asset('images/route.png') }}" />
                    </div>
                    <div class="workdiv">
                        <img class="workimg" src="{{ asset('images/calendar.png') }}" />
                    </div>
                    <div class="workdiv">
                        <img class="workimg" src="{{ asset('images/luggage.png') }}" />
                    </div>
                    <div class="workdiv">
                        <img class="workimg" src="{{ asset('images/bus.png') }}" />
                    </div>
                </div>

                <div class="flex-grow-1 position-relative video-card">
                    <div class="video-card-content">
                        <div>
                            <h3 class="fw-bold">HOW IT WORKS</h3>
                            <h1 class="fw-bold">Trip <br />Booking</h1>
                        </div>
                        <div class="play-btn">
                            <img class="btnplay" src="{{ asset('images/PlayButton.png') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="py-5 cstContact">
        <div class="container">
            <h1 class="mb-4">Contact Information</h1>
            <div class="row">
                <div class="col-6 col-md-4 mb-4"><strong><span class="contactheading">Phone:</span></strong> +234
                    8132941992</div>
                <div class="col-6 col-md-4 mb-4"><strong><span class="contactheading">Email:</span></strong>
                    info@PMT.com</div>
                <div class="col-12 col-md-10 mb-4"><strong><span class="contactheading">Address:</span></strong> 123
                    Anywhere Street, Any City, Lagos</div>
                <div class="col-12 col-md-2"><a class="btn btn-primary w-100" href="#">Contact Us</a></div>
            </div>

            <div class="map-container mt-5">
                <!-- Replace with real map -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d4055346.1372355684!2d3.1621098993140286!3d6.97401145617876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1speace%20mass%20transit!5e0!3m2!1sen!2sng!4v1747661492524!5m2!1sen!2sng"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    @include('sweetalert::alert')
</body>

</html>
