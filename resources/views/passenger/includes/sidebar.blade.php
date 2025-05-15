<div class="aside sidebar-right col-lg-4 d-none d-md-block">
    <div class="account-info card">
        <div class="card-innr">
            <div class="user-account-status">
                <h6 class="card-title card-title-sm">Your Account Status</h6>
                <div class="gaps-1-5x"></div>
                <ul class="btn-grp">
                    <li><a href="javascript:void(0)" class="btn btn-xs btn-auto btn-success">Email
                            Verified</a></li>
                    @if (Auth::user()->kyc_status == null || Auth::user()->kyc_status == "Rejected")
                        <li><a href="{{ route('kyc.initialize') }}" class="btn btn-xs btn-auto btn-info"><span>Get
                                    Verified</span></a></li>
                    @elseif(Auth::user()->kyc_status == 'Awaiting Verification')
                        <li><a href="{{ route('kyc.initialize') }}" class="btn btn-xs btn-auto btn-warning">Awaiting
                                Verification</a></li>
                    @else
                    <li><a href="{{ route('kyc.initialize') }}" class="btn btn-xs btn-auto btn-success">Account
                        Verified</a></li>
                    @endif
                </ul>
            </div>
            <div class="gaps-2-5x"></div>
            <!--<div class="user-receive-wallet"><h6 class="card-title card-title-sm">Receiving Wallet</h6><div class="gaps-1x"></div><div class="d-flex justify-content-between"><span>0xc0BCC9...E0D64f35 <a href="javascript:void(0)" data-toggle="modal" data-target="#edit-wallet" class="user-wallet link link-ucap">Edit</a></div></div>-->
        </div>
    </div>
    <div class="referral-info card">
        <div class="card-innr">
            <div class="card-head has-aside">
                <h6 class="card-title card-title-sm">Earn with Referral</h6>
                <div class="card-opt"><a href="/account/referrals" class="link ucap">More<em
                            class="fas fa-angle-right ml-1"></em></a></div>
            </div>
            <p class="pdb-0-5x"><strong>Invite your friends & family.</strong></p>
            <div class="copy-wrap mgb-0-5x"><span class="copy-feedback"></span><em
                    class="copy-icon fas fa-link"></em><input type="text" class="copy-address"
                    value="{{ env('APP_URL') }}/invite?ref={{ Auth::user()->referral_code }}" readonly /><button
                    class="copy-trigger copy-clipboard"
                    data-clipboard-text="{{ env('APP_URL') }}/invite?ref={{ Auth::user()->referral_code }}"><em
                        class="ti ti-files"></em></button>
            </div>
        </div>
    </div>
    <div class="kyc-info card">
        <div class="card-innr">
            <h6 class="card-title card-title-sm">Identity Verification - KYC</h6>
            <p>To comply with regulation, participant will have to go through identity verification.</p>
            @if (Auth::user()->kyc_status == null)
                <p class="lead text-light pdb-0-5x">You have not submitted your documents to verify your
                    identity (KYC).</p><a href="{{ route('kyc.initialize') }}"
                    class="btn btn-sm m-2 btn-icon btn-primary">Click to Proceed</a>
            @elseif(Auth::user()->kyc_status == 'Awaiting Verification')
                <p class="small">We will review your information and if all is in order will approve your identity. You
                    will be notified by email once we verified your identity (KYC).</p>
            @elseif(Auth::user()->kyc_status == 'Rejected')
            <p>We were having difficulties verifying your identity. In our verification process, we found information are incorrect or missing. Please re-submit the application again and verify your identity.</p>

            <a href="{{ route('kyc.view') }}" class="btn btn-sm m-2 btn-icon btn-secondary">View KYC</a>

            <a href="{{ route('kyc.resubmit') }}" class="btn btn-sm m-2 btn-icon btn-primary">Resubmit</a>
            @else
            <p class="lead text-success pdb-0-5x"><strong>Identity (KYC) has been verified.</strong></p>

            <p>One of our team verified your identity. You are now eligible to buy and sell on our P2P platform.</p>

            <a href="{{ route('portal.buyp2p') }}" class="btn btn-sm m-2 btn-icon btn-primary">P2P Market Place</a>

            <a href="{{ route('kyc.view') }}" class="btn btn-sm m-2 btn-icon btn-success">View KYC</a>
            @endif
        </div>
    </div>
</div>
