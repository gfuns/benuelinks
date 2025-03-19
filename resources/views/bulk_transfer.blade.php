<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Bulk Transfers | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">

    <link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style type="text/css">
        .nobreak {
            white-space: nowrap;
        }

        @media (min-width: 576px) {
            .sli {
                padding-right: 80px;
            }

            .table td {
                padding-right: 15px;
            }
        }
    </style>
</head>

<body class="admin-dashboard page-user">
    @include('includes.nav')
    @php
        $trackingCode = Session::get('bulkTransferSession');
    @endphp

    <div class="page-content">
        <div class="container">
            <div class="card content-area offset-md-2 col-md-8 jutify-center">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title mb-3">
                            Bulk Transfers
                        </h4>

                    </div>

                    @if (Session::has('bulkTransferSession'))
                    <div class="row col-12">
                        <div class="col-12 col-lg-12 ps-4 pe-4 mb-5">
                            <table class="mb-0 table-hover table-bordered" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="2">
                                            <h4>Your Upload has been offloaded to memory and is currently been analyzed
                                                for errors.</h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2">
                                            <h5>Use the <strong>View Upload Report</strong> button below to view your
                                                upload report and Save it to the database.</h5>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2">
                                            <h5 style="color: red">Note: You must view report, fix all upload
                                                issues/errors and click the Finalize Upload button before information of
                                                your upload would be persisted on the database. Failure to do this will
                                                result to your upload being discarded.</h5>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2">
                                            <a href="{{ route('bulkTransferUploadReport', [$trackingCode]) }}"
                                                class="btn btn-primary w-100 me-2">View Upload Report</a>
                                        </th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                    @else
                        <form method="POST" action="{{ route('processBulkTransfer') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row col-12">



                                <div class="mb-3 col-md-12 col-12">
                                    <label class="input-item-label">File Name</label>
                                    <div class="input-wrap">
                                        <input name="file_name" class="input-bordered" type="text"
                                            placeholder="Enter File Name">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 col-12">
                                    <label class="input-item-label">Narration/Memo</label>
                                    <div class="input-wrap">
                                        <input name="memo" class="input-bordered" type="text"
                                            placeholder="Enter Narration/Memo" required>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 col-12">
                                    <label class="input-item-label">Select File To Upload</label>
                                    <div class="input-wrap">
                                        <input name="payment_file" class="input-bordered" type="file"
                                            placeholder="Enter File Name">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 col-12 mt-2">
                                    <div class=" input-with-label">
                                        <label class="input-item-label">File Template:</label>
                                        <a href="{{ asset('Payment_Upload_Template.xls') }}">[Download
                                            Template]</a>
                                    </div>
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Bank Codes:</label>
                                        <a href="{{ route("exportBankCodes") }}">[Download Bank
                                            Codes]</a>
                                    </div>
                                </div>

                                <input type="hidden" name="tracking_code" value="{{ $trackingcode }}" />
                            </div>

                            <div class="row col-6">
                                <div class="mb-3 col-md-12 col-12">
                                    <button class="btn btn-md btn-primary" type="submit">Process Bulk Transfer</button>
                                </div>
                            </div>


                        </form>
                    @endif

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
    <script src="{{ asset('assets/js/app.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        const cacheRoute = @json(route('super.clearCache'));
    </script>


    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire(
                'Successful',
                {{ Js::from(Session::get('success')) }},
                'success'
            )
        </script>
    @endif

    @if (Session::has('error'))
        <script type="text/javascript">
            Swal.fire(
                'Error',
                {{ Js::from(Session::get('error')) }},
                'error'
            )
        </script>
    @endif
</body>

</html>
