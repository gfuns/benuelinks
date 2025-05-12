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


    <script type="text/javascript">
        document.getElementById("ticketing").classList.add('active');
        document.getElementById("bookticket").classList.add('show');
        document.getElementById("book").classList.add('active');
    </script>
@endsection
