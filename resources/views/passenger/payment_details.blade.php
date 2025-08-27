<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Peace Mass Transit (PMT) | Payment Details</title>
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
            <h4><strong>Payment Details </strong></h4>

            <div class="card content-area">
                <div class="card-innr">

                    <div class="row m-4">
                        <h5 style="font-size: 16px">To complete your booking, Please make a transfer of <b>&#8358;{{ number_format($paymentDetails->amount, 2) }}</b> to the account details shown below:</h5>

                        <table class="table" style="color:black; font-size: 16px">
                            <tbody>
                                <tr>
                                    <td class="" width="30%"><strong>Bank Name:</strong></td>
                                    <td class="">{{ $paymentDetails->bank }}</td>
                                </tr>

                                <tr>
                                    <td class=""><strong>Account Number:</strong></td>
                                    <td class="">{{ $paymentDetails->account_number }}</td>
                                </tr>

                                <tr>
                                    <td class=""><strong>Account Name:</strong></td>
                                    <td class="">{{ $paymentDetails->account_name }}</td>
                                </tr>

                            </tbody>
                        </table>

                        <h5 style="color:black"><u><b>Please Note:</b></u> <br>
                            <ul style="list-style: disc">
                                <li class="mt-2">The displayed account is only valid for 10 Minutes.</li>
                                <li class="mt-2">Ensure you send the exact amount as displayed. Underpayment or Overpayment will
                                    result in the transaction marked as failed. Refund will take about 21 days to be processed.</li>
                            </ul>

                        </h5>

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

<script>
    setInterval(function() {
        location.reload();
    }, 60000); // 60000 milliseconds = 1 minute
</script>

</body>

</html>
