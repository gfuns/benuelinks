@extends('admin.layouts.app')
@section('content')

    <div class="page-innerxxx">
        <div class="m-4 d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
            <div>
                <h3 class="fw-bold mb-3">Terminal Check-In ({{ Auth::user()->terminal->terminal }})</h3>
                <h6 class="op-7 mb-2">Input booking number to search for active tickets and proceed to ticket validation.
                    Please Note that validating a customer's ticket before his/her arrival at the terminal is strictly
                    prohibited and would attract sanctions.</h6>
            </div>
        </div>
        <div class="">
            <div class="col-sm-12 col-md-12 ms-3">
                <form method="GET" action="">

                    <div class="row">

                        <div class="col-12 col-md-10">
                            <div class="form-group">
                                <input type="text" name="booking_number" class="form-control rounded-pill"
                                    placeholder="Enter Booking Number" value="{{ $searchParam }}"
                                    style="height: 50px !important">

                                @error('booking_number')
                                    <span class="" role="alert">
                                        <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>


                        <div class="col-12 col-md-2 pillButton">
                            <button type="submit" class="btn btn-warning btn-md rounded-pill ">View Details</button>
                        </div>

                    </div>


                </form>
            </div>

            @if (isset($searchResults))
                <div class="col-sm-12 col-md-12">
                    <div class="" style="background: #fff">
                        <div class="card-header m-4 pt-4 ps-4 d-flex align-items-center">
                            <div class="card-title" style="font-size: 16px">Search Result</div>
                        </div>
                        <div class="table-responsive m-4 pb-5">

                            <table style="width: 98%" class="table mb-0 table-hover table-centered">
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
                                    @foreach ($searchResults as $bk)
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
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
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

                                    @if (count($searchResults) < 1)
                                        <div class="card content-area">
                                            <div class="card-innr">
                                                <tr>
                                                    <td colspan="8">
                                                        <div class="col-xl-12 col-12 job-items job-empty">
                                                            <div class="text-center mt-4"><i class="far fa-sad-tear"
                                                                    style="font-size: 30px"></i>
                                                                <h6 class="mt-2">No Booking Record Found For Your Query
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </div>
                                        </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-sm-12 col-md-12">
                <div class="" style="background: #fff">
                    <div class="card-header m-4 pt-5 pb-3 ps-4 d-flex align-items-center">
                        <div class="card-title" style="font-size: 16px">Scheduled Trips For {{ $period }}</div>
                        <button class="btn btn-primary ms-auto btn-sm" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">
                            <i class="fa fa-plus"></i>
                            Book Passenger
                        </button>
                    </div>
                    <div class="card-body m-4 pb-5">

                        <div class="table-responsive">

                            <table class="table mb-0 text-nowrap table-hover table-centered">
                                <thead>
                                    <tr>
                                        <th scope="col">S/No.</th>
                                        <th scope="col">Travel Route</th>
                                        <th scope="col">Vehicle No.</th>
                                        <th scope="col">Driver</th>
                                        <th scope="col">Available Seats</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scheduledTrips as $trip)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $trip->travelRoute() }}</td>
                                            <td>@php echo $trip->getvehicle() @endphp</td>
                                            <td>@php echo $trip->getdriver() @endphp</td>
                                            <td>{{ $trip->availableSeats() }} Seats</td>
                                            <td>
                                                @if ($trip->status == 'scheduled')
                                                    <span class="badge badge-warning p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'boarding in progress')
                                                    <span class="badge badge-info p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'trip suspended')
                                                    <span class="badge badge-danger p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'in transit')
                                                    <span class="badge badge-info p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'trip successful')
                                                    <span class="badge badge-success p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @endif
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


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> New Passenger Booking</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                @php
                    $today = now()->toDateString();
                    $minDate = now()->hour >= 12 ? now()->addDay()->toDateString() : $today;
                @endphp
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
                                placeholder="Select Travel Date" min="{{ $minDate }}" required>
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
                            <select id="gender" name="gender" class="form-select" data-width="100%" required>
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

    <script type="text/javascript">
        document.getElementById("dashboard").classList.add('active');
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
