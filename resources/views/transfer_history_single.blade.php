<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Transfer History (Single) | {{ env('APP_NAME') }}</title>
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


    <div class="page-content">
        <div class="container">
            <div class="card content-area">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title mb-3">
                            Transfer History (Single)
                        </h4>
                    </div>


                    <div class="table-responsive">
                        <table class="data-table dt-filter-init admin-tnx nobreak">
                            <thead>
                                <tr class="data-item data-head">
                                    <th class="data-col sli">S/No</th>
                                    <th class="data-col sli">Beneficiary Name</th>
                                    <th class="data-col sli">Account Number</th>
                                    <th class="data-col sli">Bank</th>
                                    <th class="data-col sli">Amount</th>
                                    <th class="data-col sli">Made By</th>
                                    <th class="data-col sli">Status</th>
                                    <th class="data-col sli">Comment</th>
                                    <th class="data-col sli">Trans. Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $data)
                                    <tr class="data-item" id="tnx-item-{{ $data->id }}">
                                        <td class="data-col dt-tnxno">
                                            <span class="sub sub-s2 token-amount">{{ $loop->index + 1 }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">{{ $data->account_name }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span
                                                class="sub sub-s2 token-amount">{{  $data->account_number }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span
                                                class="sub sub-s2 token-amount">{{  $data->bank_name }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span
                                                class="sub sub-s2 token-amount">&#8358;{{ number_format($data->amount, 0) }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">{{ $data->user->last_name.", ".$data->user->first_name }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">{{ucwords($data->status) }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">{{ucwords($data->remark) }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span
                                                class="sub sub-s2 token-amount">{{ date_format($data->created_at, 'jS M, Y g:i:sa') }}</span>
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
