@extends('admin.layouts.app')
@section('content')
    <div class="container" style="margin-bottom: 100px">
        <div class="page-inner">
            <div class="row">
                @if (!isset($bookingNumber) && !isset($bookingData))
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Extra Luggage Billing</div>
                            </div>

                            <div class="card-body">

                                <form method="GET" action="">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="bookingNumber"><strong>Booking Number</strong></label>
                                                <input type="text" name="booking_number" class="form-control"
                                                    id="bookingNumber" placeholder="Booking Number" required />

                                                @error('booking_number')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-action">
                                        <button type="submit" class="btn btn-primary">Verify Booking Details</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isset($bookingNumber) && isset($bookingData))
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Booking Details</div>
                            </div>

                            <div class="card-body">
                                <table class="table" style="color:black; font-size: 16px">
                                    <tbody>
                                        <tr>
                                            <td class=""><strong>Booking Number:</strong></td>
                                            <td class="">{{ $bookingData->booking_number }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Passenger Name:</strong></td>
                                            <td class="">{{ $bookingData->full_name }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Travel Route:</strong></td>
                                            <td class="">{{ $bookingData->travelRoute() }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Bus:</strong></td>
                                            <td class="">{{ $bookingData->vehicle_type }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Seat Selection:</strong></td>
                                            <td class="">Seat {{ $bookingData->seat }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Travel Date:</strong></td>
                                            <td class="">{{ $bookingData->travel_date }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Travel Fare:</strong></td>
                                            <td class="">&#8358; {{ number_format($bookingData->travel_fare, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Payment Status:</strong></td>
                                            <td class="">{{ ucwords($bookingData->payment_status) }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Billing Calculator</div>
                            </div>

                            <div class="card-body">

                                <form method="POST" action="{{ route('admin.processLuggageBilling') }}">
                                    @csrf
                                    @if ($bookingData->payment_status == 'paid')
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="bookingNumber"><strong>Weight Of Luggage</strong></label>
                                                    <input type="text" name="luggage_weight" class="form-control"
                                                        id="weight" placeholder="Weight Of Luggage" required />

                                                    @error('weight')
                                                        <span class="" role="alert">
                                                            <strong
                                                                style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="bookingNumber"><strong>Amount Payable</strong></label>
                                                    <input type="text" name="amount" class="form-control" id="amount"
                                                        placeholder="Amount Payable" required readonly />

                                                    @error('amount')
                                                        <span class="" role="alert">
                                                            <strong
                                                                style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="paymentChannel"><strong>Payment Channel</strong></label>
                                                    <select id="paymentChannel" name="payment_channel" class="form-select"
                                                        data-width="100%" required>
                                                        <option value="">Select Payment Channel</option>
                                                        {{-- <option value="Cash">Cash</option> --}}
                                                        <option value="Transfer">Transfer</option>
                                                        <option value="Card Payment">Card Payment</option>
                                                    </select>

                                                    @error('payment_channel')
                                                        <span class="" role="alert">
                                                            <strong
                                                                style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="booking_id" class="form-control"
                                            value="{{ $bookingData->id }}" required />

                                        <input type="hidden" name="fee" class="form-control" id="fee"
                                            value="{{ $config->value }}" required />

                                        <div class="card-action">
                                            <button type="submit" class="btn btn-primary w-100">Submit Details</button>
                                        </div>
                                    @else
                                        <div class="alert alert-warning mt-3" role="alert">
                                            <strong>Warning!</strong> Luggage billing can only be processed for bookings
                                            with
                                            payment status marked as <b>PAID</b>.
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById("elb").classList.add('active');
    </script>
@endsection

@section('customjs')
    <script>
        document.getElementById('weight').addEventListener('keyup', calculateCost);
        document.getElementById('weight').addEventListener('change', calculateCost);

        function calculateCost() {
            const fee = parseFloat(document.getElementById('fee').value) || 0;
            const weight = parseFloat(document.getElementById('weight').value) || 0;

            const cost = fee * weight;

            document.getElementById('amount').value = cost.toFixed(2);
        }
    </script>
@endsection
