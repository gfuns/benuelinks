@extends('admin.layouts.app')
@section('content')
    <div class="container" style="margin-bottom: 100px">
        <div class="page-inner">
            <div class="row">
                @if (!isset($bookingNumber) && !isset($bookingData))
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Ticket Rerouting</div>
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
                                            <td class="">&#8358; {{ number_format($bookingData->travel_fare, 2) }}
                                            </td>
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
                                <div class="card-title">Reroute Ticket</div>
                            </div>

                            <div class="card-body">
                                @php
                                    $today = now()->toDateString();
                                    $minDate = now()->hour >= 12 ? now()->addDay()->toDateString() : $today;
                                @endphp

                                <form method="POST" action="{{ route('admin.processTicketRerouting') }}">
                                    @csrf
                                    @if ($bookingData->payment_status == 'paid')
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="travDater"><strong>Travel Date</strong></label>
                                                    <input id="travDater" type="date" name="travel_date"
                                                        class="form-control" placeholder="Select Travel Date"
                                                        min="{{ $minDate }}" onkeydown="return false"
                                                        onpaste="return false" ondrop="return false" required>

                                                    @error('date')
                                                        <span class="" role="alert">
                                                            <strong
                                                                style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="destinationr"><strong>Destination</strong></label>
                                                    <select id="destinationr" name="destination" class="form-select"
                                                        data-width="100%" required>
                                                        <option value="">Select Destination</option>
                                                    </select>

                                                    @error('destination')
                                                        <span class="" role="alert">
                                                            <strong
                                                                style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="depTimer"><strong>Preferred Departure Time</strong></label>
                                                    <select id="depTimer" name="departure_time" class="form-select"
                                                        data-width="100%" required>
                                                        <option value="">Select Departure Time</option>
                                                    </select>

                                                    @error('departure_time')
                                                        <span class="" role="alert">
                                                            <strong
                                                                style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="vehChoicer"><strong>Choice of Vehicle</strong></label>
                                                    <select id="vehChoicer" name="vehicle_choice" class="form-select"
                                                        data-width="100%" required>
                                                        <option value="">Select Choice Of Vehicle</option>
                                                        @foreach ($vehicleTypes as $vt)
                                                            <option value="{{ $vt->model }}">{{ $vt->model }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('vehicle_choice')
                                                        <span class="" role="alert">
                                                            <strong
                                                                style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="seatr"><strong>Seat Number</strong></label>
                                                    <select id="seatr" name="seat_number" class="form-select"
                                                        data-width="100%" required>
                                                        <option value="">Select Seat Number</option>
                                                    </select>

                                                    @error('seat_number')
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


                                        <div class="card-action">
                                            <button type="submit" class="btn btn-primary w-100">Submit Details</button>
                                        </div>
                                    @else
                                        <div class="alert alert-warning mt-3" role="alert">
                                            <strong>Warning!</strong> Ticket Rerouting can only be processed for bookings
                                            with
                                            payment status marked as <b>PAID</b>.
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
        document.getElementById("rerouting").classList.add('active');
    </script>
@endsection

@section('customjs')
    <script type="text/javascript">
        $('#travDater').change(function() {
            var terminal = {{ Js::from(Auth::user()->terminal->id) }};
            var date = $(this).val();
            $('#destinationr').html(
                '<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
            $.ajax({
                url: "/ajax/get-schedules/" + terminal + "/" + date,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var options = "<option value=''>Select Destination</option>";
                    $.each(data, function(key, value) {
                        options += "<option value='" + key + "'>" + value + "</option>";
                    });
                    $('#destinationr').html(options);
                }
            });
        });

        $('#destinationr').change(function() {
            var terminal = {{ Js::from(Auth::user()->terminal->id) }};
            var destination = $(this).val();
            var date = $('#travDater').val();
            $('#depTimer').html(
                '<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
            $.ajax({
                url: "/ajax/get-times/" + terminal + "/" + destination + "/" + date,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var options = "<option value=''>Select Departure Time</option>";
                    $.each(data, function(key, value) {
                        options += "<option value='" + value + "'>" + value + "</option>";
                    });
                    $('#depTimer').html(options);
                }
            });
        });

        $('#depTimer').change(function() {
            var terminal = {{ Js::from(Auth::user()->terminal->id) }};
            var destination = $('#destinationr').val();
            var date = $('#travDater').val();
            var time = $(this).val();
            $('#seatr').html(
                '<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
            $.ajax({
                url: "/ajax/get-seats/" + terminal + "/" + destination + "/" + date + "/" + time,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var options = "<option value=''>Available Seats</option>";
                    $.each(data.availableSeats, function(index, value) {
                        options += "<option value='" + value + "'> Seat " + value + "</option>";
                    });
                    $('#seatr').html(options);
                }
            });
        });
    </script>
@endsection
