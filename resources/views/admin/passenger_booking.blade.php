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
                                <button class="btn btn-primary btn-round ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    Book Passenger
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12">
                                <form method="GET" action="{{ route('admin.searchBooking') }}">

                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Booking Number</strong></label>
                                                <input type="text" name="booking_number" class="form-control"
                                                    placeholder="Enter Booking Number" value="{{ $searchParam }}">

                                                @error('booking_number')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>


                                        <div class="col-md-3 filterButton">
                                            <button type="submit" class="btn btn-primary btn-md">Search For Record</button>
                                        </div>

                                        <div class="col-md-1 filterButton">
                                            <button type="button" class="btn btn-secondary btn-sm cstFilter"
                                                style="border: 1px solid black;" data-bs-toggle="modal"
                                                data-bs-target="#filterBookings"><i class="fas fa-filter"
                                                    style="font-size:16px"></i></button>
                                        </div>
                                    </div>


                                </form>
                            </div>


                            <hr />

                            <div class="table-responsive">

                                <table id="pagedexample" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Booking Number.</th>
                                            <th scope="col">Passenger Details</th>
                                            <th scope="col">Travel Route</th>
                                            <th scope="col">Departure Date/Time</th>
                                            <th scope="col">Booking Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $bk)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $bk->booking_number }} </td>
                                                <td class="align-middle"> {{ $bk->full_name }}<br /><span
                                                        style="font-size: 12px">{{ $bk->phone_number }}</span> </td>
                                                <td class="align-middle">{{ $bk->travelRoute() }}</td>
                                                <td class="align-middle">
                                                    {{ date_format(new DateTime($bk->travel_date), 'jS M, Y') }}
                                                    {{ $bk->departure_time }}
                                                </td>
                                                <td class="align-middle">
                                                    {{ date_format($bk->created_at, 'jS M, Y g:i a') }}
                                                </td>
                                                <td>
                                                    @if ($bk->booking_status == 'validated')
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 10px">{{ ucwords($bk->booking_status) }}</span>
                                                    @else
                                                        <span class="badge badge-warning p-2"
                                                            style="font-size: 10px">{{ ucwords($bk->booking_status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-group dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" style="">
                                                            <li>
                                                                <a class="dropdown-item mb-2" href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#bookingDetails"
                                                                    data-backdrop="static" data-myid="{{ $bk->id }}"
                                                                    data-bookingno="{{ $bk->booking_number }}"
                                                                    data-passenger="{{ $bk->full_name }}"
                                                                    data-phoneno="{{ $bk->phone_number }}"
                                                                    data-route="{{ $bk->travelRoute() }}"
                                                                    data-date="{{ date_format(new DateTime($bk->travel_date), 'l jS M, Y') }} {{ $bk->departure_time }}"
                                                                    data-bookingstatus="{{ ucwords($bk->booking_status) }}"
                                                                    data-vehicletype="{{ $bk->vehicle_type }}"
                                                                    data-paymentchannel="{{ ucwords($bk->payment_channel) }}"
                                                                    data-bookingmethod="{{ ucwords($bk->booking_method) }} Booking"
                                                                    data-boarding="{{ ucwords($bk->boarding_status) }}"
                                                                    data-amount="{{ number_format($bk->travel_fare, 2) }}"
                                                                    data-seat="{{ $bk->seat }}"
                                                                    data-nok="{{ $bk->nok }}"
                                                                    data-nokphone="{{ $bk->nok_phone }}"
                                                                    data-paystatus="{{ ucwords($bk->payment_status) }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>View
                                                                    Details</a>
                                                            </li>
                                                            @if ($bk->payment_status == 'paid')
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('admin.printBookingTicket', [$bk->id]) }}"
                                                                        target="_blank"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Print
                                                                        Receipt</a>
                                                                </li>
                                                            @endif
                                                            @if ($bk->booking_status == 'booked')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.validateTicket', [$bk->id]) }}"
                                                                        onclick="return confirm('Are you sure you want to validate this ticket?');"><i
                                                                            class="fe fe-trash dropdown-item-icon"></i>Validate
                                                                        Ticket</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
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
        </div>
    </div>


    <div class="modal fade" id="bookingDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        View Booking Details
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>

                            <tr>
                                <td class=""><strong>Booking Number</strong></td>
                                <td class=""><span id="vbookingno"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Travel Route:</strong></td>
                                <td class=""><span id="vroute"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Selected Vehicle:</strong></td>
                                <td class=""><span id="vvehicletype"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Departure Date/Time:</strong></td>
                                <td class=""><span id="vdate"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Passenger Name:</strong></td>
                                <td class=""><span id="vpassenger"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Passenger Phone Number:</strong></td>
                                <td class=""><span id="vphoneno"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Seat Number:</strong></td>
                                <td class=""><span id="vseat"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Next Of Kin:</strong></td>
                                <td class=""><span id="vnok"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Next Of Kin Phone Number:</strong></td>
                                <td class=""><span id="vnokphone"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Booking Status:</strong></td>
                                <td class=""><span id="vbookingstatus"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Booking Method:</strong></td>
                                <td class=""><span id="vbookingmethod"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Fare Paid:</strong></td>
                                <td class="">&#8358;<span id="vamount"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Payment Channel</strong></td>
                                <td class=""><span id="vpaymentchannel"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Payment Status</strong></td>
                                <td class=""><span id="vpaystatus"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Boarding Status</strong></td>
                                <td class=""><span id="vboarding"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> New Passenger Booking</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.processBooking') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Travel Date</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="travDate" type="date" name="travel_date" class="form-control"
                                placeholder="Select Travel Date" required>
                            <div class="invalid-feedback">Please select travel date.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Destination</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="destination" name="destination" class="form-select" data-width="100%" required>
                                <option value="">Select Destination</option>
                            </select>
                            <div class="invalid-feedback">Please select destination.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Preferred Departure Time</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="depTime" name="departure_time" class="form-select" data-width="100%" required>
                                <option value="">Select Departure Time</option>
                            </select>
                            <div class="invalid-feedback">Please select departure time.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Choice of Vehicle</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="vehChoice" name="vehicle_choice" class="form-select" data-width="100%" required>
                                <option value="">Select Choice Of Vehicle</option>
                                @foreach ($vehicleTypes as $vt)
                                    <option value="{{ $vt->model }}">{{ $vt->model }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select choice of vehicle.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Seat Number</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="seat" name="seat_number" class="form-select" data-width="100%" required>
                                <option value="">Select Seat Number</option>
                            </select>
                            <div class="invalid-feedback">Please select seat number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Passenger Name</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="passenger_name" class="form-control"
                                placeholder="Enter Passenger Name" required>
                            <div class="invalid-feedback">Please enter passenger name.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Passenger Phone Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="phone_number" class="form-control"
                                placeholder="Enter Passenger Phone Number" required>
                            <div class="invalid-feedback">Please enter passenger phone number.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Gender</strong> </label>
                            <select id="gender" name="gender" class="form-select" data-width="100%"
                                required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <div class="invalid-feedback">Please select gender.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Payment Channel</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="channel" name="payment_channel" class="form-select" data-width="100%"
                                required>
                                <option value="">Select Payment Channel</option>
                                {{-- <option value="Cash">Cash</option> --}}
                                <option value="Transfer">Transfer</option>
                                <option value="Card Payment">Card Payment</option>
                            </select>
                            <div class="invalid-feedback">Please select payment channel.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Emergency Contact</strong> </label>
                            <input type="text" name="nok" class="form-control"
                                placeholder="Enter Emergency Contact">
                            <div class="invalid-feedback">Please enter emergency contact.</div>
                        </div>

                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label"><strong>Emergency Contact's Number</strong> </label>
                            <input type="text" name="nok_phone" class="form-control"
                                placeholder="Enter Emergency Contact's Number">
                            <div class="invalid-feedback">Please enter emergency contact's number.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Submit Details</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterBookings" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        Filter Booking Records
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.filterBookings') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- form group -->

                            <div class="mb-3 col-12">
                                <label class="form-label"><strong>Travel Route</strong></label>
                                <select id="trvRoute" name="travel_route" class="form-select" data-width="100%"
                                    required>
                                    <option value="null">Select Travel Route</option>
                                    @foreach ($travelRoutes as $troute)
                                        <option value="{{ $troute->destination }}"
                                            @if ($route == $troute->destination) selected @endif>{{ $troute->travelRoute() }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select travel route.</div>
                            </div>

                            <div class="mb-3 col-12">
                                <label class="form-label"><strong>Booking Status</strong></label>
                                <select id="bkStatus" name="booking_status" class="form-select" data-width="100%">
                                    <option value="null">Select Booking Status</option>
                                    <option value="booked" @if ($status == 'booked') selected @endif>Booked
                                    </option>
                                    <option value="validated" @if ($status == 'validated') selected @endif>Validated
                                    </option>
                                </select>
                                <div class="invalid-feedback">Please select booking status.</div>
                            </div>

                            <div class="mb-3 col-12">
                                <label class="form-label"><strong>Travel Date</strong></label>
                                <input type="date" name="travel_date" value="{{ $date }}"
                                    class="form-control" placeholder="Select Travel Date">
                                <div class="invalid-feedback">Please select travel date.</div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Filter Records</button>
                        <button type="button" class="btn btn-outline-primary ms-2"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        document.getElementById("ticketing").classList.add('active');
    </script>
@endsection

@section('customjs')
    <script type="text/javascript">
        $('#travDate').change(function() {
            var terminal = {{ Js::from(Auth::user()->terminal->id) }};
            var date = $(this).val();
            $('#destination').html(
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
                    $('#destination').html(options);
                }
            });
        });

        $('#destination').change(function() {
            var terminal = {{ Js::from(Auth::user()->terminal->id) }};
            var destination = $(this).val();
            var date = $('#travDate').val();
            $('#depTime').html(
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
                    $('#depTime').html(options);
                }
            });
        });

        $('#depTime').change(function() {
            var terminal = {{ Js::from(Auth::user()->terminal->id) }};
            var destination = $('#destination').val();
            var date = $('#travDate').val();
            var time = $(this).val();
            $('#seat').html(
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
                    $('#seat').html(options);
                }
            });
        });
    </script>
@endsection
