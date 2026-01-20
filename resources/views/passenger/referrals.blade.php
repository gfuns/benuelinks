<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }} - No. 1 P2P Platform">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>{{ env("APP_NAME") }} | Refferals</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">
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

                <div class="main-content col-lg-8">
                    <div class="content-area content-area-mh card user-account-pages page-referral">
                        <div class="card-innr">
                            <div class="card-head">
                                <h2 class="card-title card-title-lg">Referrals</h2>
                            </div>
                            <div class="card-text">
                                <p>Invite your friends and family using your referral link and receive referral bonuses.
                                </p>
                                <p>Imagine giving your unique referral link to your travel-happy friend and he or she
                                    signs up using your link, the bonus will be credited to your wallet's balance
                                    automatically. The strategy is simple: the more links you send to your colleagues,
                                    family and friends - the more bonuses you may earn!</p>

                            </div>

                            <div class="gaps-1x"></div>
                            <div class="referral-form">
                                <h4 class="card-title card-title-sm">Referral Link</h4>
                                <div class="copy-wrap mgb-1-5x mgt-1-5x">
                                    <span class="copy-feedback"></span>
                                    <em class="copy-icon fas fa-link"></em>
                                    <input type="text" class="copy-address"
                                        value="{{ env('APP_URL') }}/invite?ref={{ Auth::user()->referral_code }}"
                                        readonly>
                                    <button class="copy-trigger copy-clipboard"
                                        data-clipboard-text="{{ env('APP_URL') }}/invite?ref={{ Auth::user()->referral_code }}"><em
                                            class="ti ti-files"></em></button>
                                </div>
                                <p class="text-light mgmt-1x"><em><small>Use above link to refer your friend and get
                                            referral bonus.</small></em></p>
                            </div>
                            <div class="sap sap-gap"></div>
                            <div class="card-head">
                                <h4 class="card-title card-title-sm">Referral Lists</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="data-table dt-filter-init refferal-table nobreak" data-items="10">
                                    <thead>
                                        <tr class="data-item data-head">
                                            <th class="data-col serial-no"><span>S/NO.</span></th>
                                            <th class="data-col refferal-name"><span>Referral Name</span></th>
                                            <th class="data-col refferal-tokens"><span>Bonus Earned</span></th>
                                            <th class="data-col refferal-date"><span>Registration Date</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($referrals as $ref)
                                            <tr class="data-item">
                                                <td class="data-col refferal-name">{{ $loop->index + 1 }}</td>
                                                <td class="data-col refferal-name">
                                                    {{ $ref->last_name . '  ' . $ref->other_names }}</td>
                                                <td class="data-col refferal-tokens">&#8358;{{ number_format(500, 2) }}</td>
                                                <td class="data-col refferal-date">
                                                    {{ date_format($ref->created_at, 'jS M, Y g:i A') }}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>

                                </table>
                                @if (count($referrals) < 1)
                                    <div class="col-xl-12 col-12 job-items job-empty">
                                        <div class="text-center mt-4"><i class="far fa-sad-tear"
                                                style="font-size: 48px"></i>
                                            <h5 class="mt-2">No Referrals Found</h5>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
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
                        Rights Reserved. <br class="">Application Developed by <a
                            href="{{ env('DEVELOPER_WEBSITE') }}" target="_blank">{{ env('APP_DEVELOPER') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ajax-modal"></div>
    <div class="page-overlay">
        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span></div>
    </div>


    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver={{ date('his') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}?ver={{ date('his') }}"></script>

    <script type="text/javascript">
        document.getElementById("referrals").classList.add('active');
    </script>

</body>

</html>
