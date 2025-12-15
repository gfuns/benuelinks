@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Passenger Bookings</h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row m-4">
                                <h5 style="font-size: 16px">Hey ,</h5>
                                <h5 style="font-size: 16px">To complete your booking, Please make a transfer of
                                    <b>&#8358;{{ number_format($paymentDetails->amount, 2) }}</b> to the account details
                                    shown below:</h5>

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

                                <h5 style="color:black; font-size: 14px"><u><b>Please Note:</b></u> <br>
                                    <ul style="list-style: disc">
                                        <li class="mt-2">The displayed account is only valid for 10 Minutes.</li>
                                        <li class="mt-2">Ensure you send the exact amount as displayed. Underpayment or
                                            Overpayment will
                                            result in the transaction marked as failed. Refund will take about 21 days to be
                                            processed.</li>
                                    </ul>

                                </h5>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        document.getElementById("ticketing").classList.add('active');
    </script>

    <script>
        setInterval(function() {
            location.reload();
        }, 30000); // 60000 milliseconds = 1 minute
    </script>
@endsection
