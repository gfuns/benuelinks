<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Peace Mass Transit (PMT) | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-blue.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

        <style type="text/css">
            .nobreak {
                white-space: nowrap;
            }
        </style>
</head>

<body class="admin-dashboard page-user">
    @include('passenger.includes.nav')

    <div class="page-content">
        <div class="container">
            <div class="row">
                @if (isset(Auth::user()->account_number))
                    <div class="col-lg-4 order-1 order-lg-2">
                        <div class="token-statistics card card-token height-auto">
                            <div class="card-innr">
                                <div class="token-balance token-balance-s3">
                                    <div class="token-balance-text">
                                        <h6 class="card-sub-title mb-2" style="font-size: 20px;">WALLET BALANCE</h6>
                                        <span class="lead" style="font-size: 20px;">&#8358;
                                            {{ number_format(Auth::user()->wallet_balance, 2) }}&nbsp;
                                            <em class="fas fa-info-circle fs-12" data-toggle="tooltip"
                                                data-placement="right" title=""
                                                data-original-title="Combined calculations of all balances."></em></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="view-crypto">
                                        <div class="token-balance token-balance-s2">
                                            <ul class="token-balance-list d-flex justify-content-between">
                                                <li class="token-balance-sub">
                                                    <span class="sub"
                                                        style="font-size: 12px; font-weight:bold;">Customer
                                                        Deposits</span>
                                                    <span class="lead">&#8358;
                                                        {{ number_format(Auth::user()->wallet_balance, 2) }}</span>
                                                </li>
                                                <li class="token-balance-sub">
                                                    <span class="sub"
                                                        style="font-size: 12px; font-weight:bold;">Referral
                                                        Bonuses</span>
                                                    <span class="lead">&#8358; 0.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-bottom: 35px;">
                            <center><button class="btn btn-primary btn-sm w-100" data-toggle="modal"
                                    data-target="#initiateTopup">Top Up Wallet</button></center>
                        </div>
                    </div>

                    <div class="main-content col-lg-8 order-2 order-lg-1">
                        <div class="content-area card user-account-pages page-referral">
                            <div class="card-innr">
                                <div class="card-head">
                                    <h2 class="card-title card-title-lg">Wallet Transactions</h2>
                                </div>

                                <div class="gaps-1x"></div>

                                <div class="table-responsive">
                                    <table class="data-table dt-filter-init user-list nobreak">
                                        <thead>
                                            <tr class="data-item data-head">
                                                <th class="data-col">Trx. Date</th>
                                                <th class="data-col">Description</th>
                                                <th class="data-col">Amount</th>
                                                <th class="data-col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $trx)
                                                <tr class="data-item">
                                                    <td class="data-col">
                                                        <span
                                                            class="sub sub-s2 sub-email">{{ date_format($trx->created_at, 'jS M, Y g:i a') }}</span>
                                                    </td>
                                                    <td class="data-col">
                                                        <span
                                                            class="sub sub-s2 sub-email">{{ $trx->description }}</span>
                                                    </td>
                                                    <td class="data-col">
                                                        <span
                                                            class="sub sub-s2 sub-email">&#8358;{{ number_format($trx->amount, 2) }}</span>
                                                    </td>
                                                    <td class="data-col">
                                                        @if ($trx->status == 'pending')
                                                            <span
                                                                class="badge badge-outline badge-md badge-warning"><strong>{{ ucwords($trx->status) }}</strong></span>
                                                        @elseif ($trx->status == 'failed')
                                                            <span
                                                                class="badge badge-outline badge-md badge-danger text-danger"><strong>{{ ucwords($trx->status) }}</strong></span>
                                                        @else
                                                            <span
                                                                class="badge badge-outline badge-md badge-success text-success"><strong>{{ ucwords($trx->status) }}</strong></span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if (count($transactions) < 1)
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="col-xl-12 col-12 job-items job-empty">
                                                            <div class="text-center mt-4"><i class="far fa-sad-tear"
                                                                    style="font-size: 48px"></i>
                                                                <h5 class="mt-2">No Wallet Transactions Found</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- offset-lg-2 --}}
                    <div class="main-content col-lg-8 ">
                        <div class="content-area content-area-mh card user-account-pages page-referral">
                            <div class="card-innr">
                                <div class="card-head">
                                    <h2 class="card-title card-title-lg">Activate Your Wallet</h2>
                                </div>
                                <div class="card-text">
                                    <p>Your Wallet is a secure and convenient way to manage your payments and bookings
                                        on our platform.
                                    </p>
                                    <p><strong>Why Use the Wallet?</strong>
                                    <ul style="list-style-type: square; !important">

                                        <li><strong><i class="far fa-dot-circle" style="font-size: 12px"></i>
                                                Bookings:</strong> Instantly pay for your trips without
                                            needing a debit card or bank transfer every time.</li>
                                        <li><strong><i class="far fa-dot-circle" style="font-size: 12px"></i> Track
                                                Spending:</strong> View your payment history and stay on top
                                            of your travel expenses.</li>
                                        <li><strong><i class="far fa-dot-circle" style="font-size: 12px"></i> Bonus &
                                                Cashback:</strong> Receive special offers, referral bonuses,
                                            and cashback directly to your wallet.</li>
                                        <li><strong><i class="far fa-dot-circle" style="font-size: 12px"></i> Secure &
                                                Reliable:</strong> Your wallet is protected with
                                            industry-standard security measures.</li>
                                    </ul>
                                    </p>

                                    <p><strong>How It Works</strong>
                                    <ul>
                                        <li><i class="far fa-dot-circle" style="font-size: 12px"></i> Activate your
                                            wallet.</li>
                                        <li><i class="far fa-dot-circle" style="font-size: 12px"></i> Top up your
                                            wallet
                                            using your preferred payment method.</li>
                                        <li><i class="far fa-dot-circle" style="font-size: 12px"></i> Book trips and
                                            pay
                                            directly from your wallet.</li>
                                        <li><i class="far fa-dot-circle" style="font-size: 12px"></i> Receive refunds
                                            or bonuses directly into your wallet.</li>
                                    </ul>
                                    </p>
                                    <p>Once activated, you can start enjoying a faster, more efficient travel booking
                                        experience.</p>


                                    <p><strong><u>Note:</u> Wallet funds can only be used for
                                            services within this platform and are non-transferable.</strong></p>

                                </div>
                                <hr />

                                {{-- <div class="gaps-1x"></div> --}}
                                <div class="wallet-form">
                                    <h4 class="card-title card-title-sm mb-3">Setup Wallet PIN</h4>
                                    <form class="validate-modern" action="{{ route('passenger.walletPinSetup') }}"
                                        method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-item input-with-label">
                                                    <label for="new-pin" class="input-item-label">Wallet
                                                        PIN</label>
                                                    <div class="input-wrap">
                                                        <input class="input-bordered" id="new-pin" type="password"
                                                            name="wallet_pin" placeholder="Wallet PIN"
                                                            required="required" minlength="4" maxlength="4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-item input-with-label">
                                                    <label for="confirm-pin" class="input-item-label">Confirm
                                                        Wallet PIN</label>
                                                    <div class="input-wrap">
                                                        <input id="confirm-pin" class="input-bordered"
                                                            type="password" name="pin_confirmation"
                                                            placeholder="Confirm Wallet PIN"
                                                            data-rule-equalTo="#new-pin"
                                                            data-msg-equalTo="PIN do not match." required="required"
                                                            minlength="4" maxlength="4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="note note-plane note-info pdb-1x">
                                            <em class="fas fa-info-circle"></em>
                                            <p>Wallet PIN should be a minimum of 4 digits.</p>
                                        </div>
                                        <div class="gaps-1x"></div>
                                        <div class="d-sm-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary password-update"  onClick="this.disabled=true; this.innerHTML='Submiting request, please wait...';this.form.submit();">Activate
                                                Wallet</button>
                                            <div class="gaps-2x d-sm-none"></div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
            @endif


        </div>
    </div>

    </div>


    <div class="footer-bar">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12">
                    <div class="copyright-text text-center pb-3">&copy; {{ date('Y') }} {{ env('APP_NAME') }}.
                        All
                        Rights Reserved. <br class="">Application Developed by <a
                            href="{{ env('DEVELOPER_WEBSITE') }}" target="_blank">{{ env('APP_DEVELOPER') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="ajax-modal"></div>

    <div class="modal fade" id="initiateTopup" tabindex="-1">
        <div class="modal-dialog modal-dialog-md" style="margin-top:150px">
            <div class="modal-content">
                <a href="#" class="modal-close" data-dismiss="modal" aria-label="Close"><em
                        class="ti ti-close"></em></a>
                <div class="popup-body">
                    <h3 class="popup-title">Initiate Topup</h3>
                    <form class="validate-modern lang-form-submit _reload"
                        action="{{ route('passenger.initiateWalletTopup') }}" method="POST" id="lang-add-new">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Topup Amount</label>
                                    <div class="input-wrap">
                                        <input class="input-bordered" type="text" name="topup_amount"
                                            oninput="validateInput(event)" placeholder="Topup Amount" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Proceed To Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="page-overlay">
        <div class="spinner">
            <span class="sp sp1"></span>
            <span class="sp sp2"></span>
            <span class="sp sp3"></span>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/admin.app.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        document.getElementById("wallet").classList.add('active');
    </script>

</body>

</html>
