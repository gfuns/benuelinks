<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Bulk Transfer Upload Report | {{ env('APP_NAME') }}</title>
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
                    <div class="card-head has-aside mb-5">
                        <h4 class="card-title mb-3">
                            Bulk Transfer Upload Report
                        </h4>
                        @if ($uploadErrors > 0)
                            <a href="{{ route('screenBulkTransferUpload', [$trackingCode]) }}"
                                class="btn btn-primary btn-sm me-2">Resolve Upload Issues</a>
                        @else
                            <a href="{{ route('finalizeBulkTransferUpload', [$trackingCode]) }}"
                                class="btn btn-success btn-sm me-2">Finalize Extra Allowances Upload</a>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="data-table admin-tnx nobreak">
                            <thead>
                                <tr class="data-item data-head">
                                    <th class="data-col sli">S/No.</th>
                                    <th class="data-col sli">Account Name.</th>
                                    <th class="data-col sli">Account Number</th>
                                    <th class="data-col sli">Bank</th>
                                    <th class="data-col sli">Amount (&#8358;)</th>
                                    <th class="data-col sli">Status</th>
                                    <th class="data-col sli"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uploadReport as $data)
                                    <tr class="data-item" id="tnx-item-{{ $data->id }}">
                                        <td class="data-col dt-tnxno">
                                            <span class="sub sub-s2 token-amount">{{ $loop->index + 1 }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">{{ $data->account_name }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">
                                                {{ $data->account_number }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 token-amount">{{ $data->bank_name }}</span>
                                        </td>

                                        <td class="data-col dt-token">
                                            <span
                                                class="sub sub-s2 token-amount">{{ number_format($data->amount, 2) }}</span>
                                        </td>
                                        <td class="data-col dt-token">
                                            <span class="sub sub-s2 amount-pay">
                                                @if ($data->imported == 1)
                                                    <span class="badge text-success bg-light-success">
                                                        Accepted</span>
                                                @else
                                                    <span class="badge text-danger bg-light-danger">
                                                        Rejected</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="data-col text-right">
                                            <div class="relative d-inline-block">
                                                <a href="#"
                                                    class="btn btn-light-alt btn-xs btn-icon toggle-tigger"><em
                                                        class="ti ti-more-alt"></em></a>
                                                <div class="toggle-class dropdown-content dropdown-content-top-left">
                                                    <ul id="more-menu-668" class="dropdown-list">
                                                        @if ($data->imported == 0)
                                                            <li><a href="#" data-toggle="modal"
                                                                    data-target="#uploadComment"
                                                                    data-comment="{{ $data->comment }}"
                                                                    style='cursor:pointer'>
                                                                    <em class="fas fa-eye"></em>View Comment</a>
                                                            </li>
                                                            <li><a href="#" data-toggle="modal"
                                                                    data-target="#resolveUploadIssue"
                                                                    data-myid="{{ $data->id }}"
                                                                    data-bank="{{ $data->bank_code }}"
                                                                    data-accname="{{ $data->account_name }}"
                                                                    data-accno="{{ $data->account_number }}"
                                                                    data-amount="{{ $data->amount }}"
                                                                    style="cursor: pointer">
                                                                    <em class="fas fa-edit"></em>Resolve Issue</a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="pagination-bar">


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

    <div class="modal fade" id="uploadComment" tabindex="-1">
        <div class="modal-dialog modal-dialog-md modal-dialog-centered">
            <div class="modal-content">
                <a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em
                        class="ti ti-close"></em></a>
                <div class="popup-body popup-body-md">
                    <h3 class="popup-title">Bulk Transfer Upload Comment</h3>
                    <p id="comment" style="font-weight: bold; color:red"></p> Please use the resolve issue option to
                    resolve the issue stated above.
                </div>
            </div>

        </div>

    </div>


    <div class="modal fade" id="resolveUploadIssue" tabindex="-1">
        <div class="modal-dialog modal-dialog-md modal-dialog-centered">
            <div class="modal-content">
                <a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em
                        class="ti ti-close"></em></a>
                <div class="popup-body popup-body-md">
                    <h3 class="popup-title">Resolve Bulk Transfer Upload Issue</h3>
                    <form action="{{ route('resolveBulkTransferImportIssue') }}" method="POST"
                        class="adduser-form validate-modern" autocomplete="false">
                        @csrf

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Bank</label>
                                    <div class="input-wrap">
                                        <select id="bank" name="bank" class=" select-bordered select-block"
                                            required="required">
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->bank_code }}">{{ $bank->bank_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Account Name</label>
                                    <div class="input-wrap">
                                        <input id="accname" name="account_name" class="input-bordered"
                                            required="required" type="text" value=""
                                            placeholder="Enter Account Name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Account Number</label>
                                    <div class="input-wrap">
                                        <input id="accno" name="account_number" class="input-bordered"
                                            required="required" type="text" value=""
                                            placeholder="Enter Account Number" oninput="validateInput(event)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Amount</label>
                                    <div class="input-wrap">
                                        <input id="amount" name="amount" class="input-bordered"
                                            required="required" type="text" value=""
                                            placeholder="Enter Amount" oninput="validateInput(event)">
                                    </div>

                                    <input id="myid" type="hidden" name="upload_id" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>


                        <div class="gaps-1x"></div>
                        <button class="btn btn-md btn-primary" type="submit">Save Changes</button>
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
