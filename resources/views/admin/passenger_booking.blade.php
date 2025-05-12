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
                                <form method="POST" action="{{ route('admin.searchTravelRoutes') }}">
                                    @csrf

                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Booking Number</strong></label>
                                                <input type="text" name="booking_number" class="form-control"
                                                    placeholder="Enter Booking Number">

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
                                            <th scope="col">Passenger Details</th>
                                            <th scope="col">Travel Route</th>
                                            <th scope="col">Departure Date/Time</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $route)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $route->departurePoint->terminal }} </td>
                                                <td class="align-middle">{{ $route->destinationPoint->terminal }}</td>
                                                <td class="align-middle">
                                                    &#8358;{{ number_format($route->transport_fare, 2) }}</td>
                                                <td>
                                                    @if ($route->status == 'active')
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 10px">{{ ucwords($route->status) }}</span>
                                                    @else
                                                        <span class="badge badge-warning p-2"
                                                            style="font-size: 10px">{{ ucwords($route->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    {{ date_format($route->created_at, 'jS F, Y') }}
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


    <div class="modal fade" id="filterBookings" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        Filter Passenger Bookings
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class=""><strong>Take-off Point</strong></td>
                                <td class=""><span id="vdeparture"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Destination:</strong></td>
                                <td class=""><span id="vdestination"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Scheduled Date:</strong></td>
                                <td class=""><span id="vdate"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Departure Time:</strong></td>
                                <td class=""><span id="vtime"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Assigned Vehicle:</strong></td>
                                <td class=""><span id="vvehicle"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Driver Details:</strong></td>
                                <td class=""><span id="vdriver"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Status</strong></td>
                                <td class=""><span id="vstatus"></span></td>
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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Adjust Departure Time</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('admin.adjustDepartureTime') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Departure Time</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="adepartureTime" type="text" name="departure_time" class="form-control"
                                placeholder="Select Departure Time" required>
                            <div class="invalid-feedback">Please select departure time.</div>
                        </div>

                        <input id="myid" type="hidden" name="schedule_id" class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        document.getElementById("ticketing").classList.add('active');
        document.getElementById("bookticket").classList.add('show');
        document.getElementById("book").classList.add('active');
    </script>
@endsection
