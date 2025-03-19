<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="{{ env('APP_NAME') }}">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?version={{ date('his') }}">
    <title>Single Transfer | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver={{ date('his') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-green.css') }}?ver={{ date('his') }}">

    <link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body class="admin-dashboard page-user">
    @include('includes.nav')


    <div class="page-content">
        <div class="container">
            <div class="card content-area offset-md-2 col-md-8 jutify-center">
                <div class="card-innr">
                    <div class="card-head has-aside">
                        <h4 class="card-title mb-3">
                            Single Transfer
                        </h4>
                    </div>

                    <div>
                        <form method="post" action="{{ route('processSingleTransfer') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 password-toggle">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Bank</label>
                                        <div class="input-wrap">
                                            <select id="bank" name="bank" class=" select-bordered select-block"
                                                required="required">
                                                <option value="">---Select Bank---</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->bank_code }}">{{ $bank->bank_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Account Number</label>
                                        <div class="input-wrap">
                                            <input id="accountnumber" name="account_number" class="input-bordered"
                                                required="required" type="text" value=""
                                                oninput="validateInput(event)" placeholder="Account Number">
                                            <div id="validationprogress" class="valid-feedback"
                                                style="font-weight:bold;">Validating
                                                Account Number...</div>
                                            <div id="validationerror" class="invalid-feedback"
                                                style="font-weight:bold;">Account
                                                Number Validation Failed</div>
                                        </div>
                                    </div>
                                </div>

                                <div id="accountnamediv" class="col-sm-12">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Account Name</label>
                                        <div class="input-wrap">
                                            <input id="accountname" name="account_name" class="input-bordered"
                                                required="required" type="text" value="" readonly
                                                placeholder="Account Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Amount To Be Transferred</label>
                                        <div class="input-wrap">
                                            <input id="password3" name="amount" class="input-bordered"
                                                required="required" type="text" value=""
                                                oninput="validateInput(event)" placeholder="Amount To Be Transferred">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="input-item input-with-label">
                                        <label class="input-item-label">Narration</label>
                                        <div class="input-wrap">
                                            <input id="password3" name="narration" class="input-bordered" type="text" value=""  placeholder="Transaction Narration">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-md btn-primary" type="submit">Submit Transfer Request</button>
                        </form>
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

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var icon = document.querySelector(".toggle-password i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function togglePassword2Visibility() {
            var passwordInput = document.getElementById("password2");
            var icon = document.querySelector(".toggle-password-2 i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function togglePassword3Visibility() {
            var passwordInput = document.getElementById("password3");
            var icon = document.querySelector(".toggle-password-3 i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
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



        <script type="text/javascript">
            function validateInput(event) {
                const input = event.target;
                let value = input.value;

                // Remove commas from the input value
                value = value.replace(/,/g, '');

                // Regular expression to match non-numeric and non-decimal characters
                const nonNumericDecimalRegex = /[^0-9.]/g;

                if (nonNumericDecimalRegex.test(value)) {
                    // If non-numeric or non-decimal characters are found, remove them from the input value
                    value = value.replace(nonNumericDecimalRegex, '');
                }

                // Ensure there is only one decimal point in the value
                const decimalCount = value.split('.').length - 1;
                if (decimalCount > 1) {
                    value = value.replace(/\./g, '');
                }

                // Assign the cleaned value back to the input field
                input.value = value;
            }
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                // Hide the account name text field by default
                $('#accountnamediv').hide();

                // Disable the submit button by default
                $('#submitbutton').prop('disabled', true);

                // AJAX request on account number change
                $('#accountnumber').on('input', function() {
                    var accountnumber = $(this).val();
                    var bank = document.getElementById("bank").value;

                    // Check if the length of the input is between 1 and 10 digits
                    if (accountnumber.length == 10) {

                        $('#validationprogress').show();
                        $('#validationerror').hide();
                        // Make AJAX call to validate account number
                        $.ajax({
                            url: '{{ route('business.validateAccount') }}',
                            type: 'POST',
                            data: {
                                accountnumber: accountnumber,
                                bank: bank,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // Update account name field with the returned value
                                $('#accountname').val(response.account_name);
                                // Show the account name text field
                                $('#accountnamediv').show();
                                // Enable the submit button
                                $('#submitbutton').prop('disabled', false);
                                $('#validationprogress').hide();

                            },
                            error: function(xhr, status, error) {
                                $('#validationprogress').hide();
                                $('#validationerror').show();
                                // Handle errors if needed
                            }
                        });
                    }
                });
            });
        </script>


</body>

</html>
