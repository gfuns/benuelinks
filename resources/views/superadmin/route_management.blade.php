@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Route Management</h4>
                                <button class="btn btn-primary btn-round ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    Add New Travel Route
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Departure Point</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companyTravelRoutes as $route)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $route->departurePoint->terminal }} </td>
                                                <td class="align-middle">{{ $route->destinationPoint->terminal }}</td>
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
                                                <td class="align-middle">

                                                    <div class="btn-group dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" style="">
                                                            <li>
                                                                <a class="dropdown-item mb-2" href="#"
                                                                    data-bs-toggle="offcanvas" data-bs-target="#editRoute"
                                                                    data-backdrop="static" data-backdrop="static"
                                                                    data-myid="{{ $route->id }}"
                                                                    data-destination="{{ $route->destination }}"
                                                                    data-departure="{{ $route->departure }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>Edit
                                                                    Details</a>
                                                            </li>
                                                            @if ($route->status == 'active')
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('superadmin.suspendRoute', [$route->id]) }}" onclick="return confirm('Are you sure you want to suspend this travel route');"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Suspend Travel Route</a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('superadmin.activateRoute', [$route->id]) }}" onclick="return confirm('Are you sure you want to activate this travel route');"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Activate Travel Route</a>
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Add New Travel Route</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form novalidate method="post" action="{{ route('superadmin.storeRoute') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Take Off Point</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="takeoff" name="take_off_point" class="form-select" data-width="100%" required>
                                <option value="">Select Take Off Point</option>
                                @foreach ($terminals as $dp)
                                    <option value="{{ $dp->id }}">{{ $dp->terminal }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select take off point.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Destination</strong> <span
                                    class="text-danger">*</span></label>
                                    <select id="destination" name="destination" class="form-select" data-width="100%" required>
                                        <option value="">Select Destination</option>
                                        @foreach ($terminals as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->terminal }}</option>
                                        @endforeach
                                    </select>
                            <div class="invalid-feedback">Please select destination.</div>
                        </div>


                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Add Travel Route</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="editRoute" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Update Route Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('superadmin.updateRoute') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Take Off Point</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="utakeoff" name="take_off_point" class="form-select" data-width="100%" required>
                                <option value="">Select Take Off Point</option>
                                @foreach ($terminals as $dp)
                                    <option value="{{ $dp->id }}">{{ $dp->terminal }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select take off point.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Destination</strong> <span
                                    class="text-danger">*</span></label>
                                    <select id="udestination" name="destination" class="form-select" data-width="100%" required>
                                        <option value="">Select Destination</option>
                                        @foreach ($terminals as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->terminal }}</option>
                                        @endforeach
                                    </select>
                            <div class="invalid-feedback">Please select destination.</div>
                        </div>

                        <input id="myid" type="hidden" name="route_id" class="form-control" required>

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
        document.getElementById("routes").classList.add('active');
    </script>
@endsection
