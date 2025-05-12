@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Fleet Management</h4>
                                <button class="btn btn-primary btn-round ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    Add New Vehicle
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Vehicle Number</th>
                                            <th scope="col">Manufacturer</th>
                                            <th scope="col">Model/Year/Color</th>
                                            <th scope="col">Plate Number</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date Created</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companyVehicles as $vehicle)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $vehicle->vehicle_number }} </td>
                                                <td class="align-middle">{{ $vehicle->manufacturer }}</td>
                                                <td class="align-middle">{{ $vehicle->model }} / {{ $vehicle->year }} /
                                                    {{ $vehicle->color }}</td>
                                                <td class="align-middle">{{ $vehicle->plate_number }}</td>
                                                <td>
                                                    @if ($vehicle->status == 'active')
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 10px">{{ ucwords($vehicle->status) }}</span>
                                                    @elseif($vehicle->status == 'under maintenance')
                                                        <span class="badge badge-warning p-2"
                                                            style="font-size: 10px">{{ ucwords($vehicle->status) }}</span>
                                                    @else
                                                        <span class="badge badge-danger p-2"
                                                            style="font-size: 10px">{{ ucwords($vehicle->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    {{ date_format($vehicle->created_at, 'jS F, Y') }}
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
                                                                    data-bs-toggle="modal" data-bs-target="#vehicleDetails"
                                                                    data-backdrop="static" data-myid="{{ $vehicle->id }}"
                                                                    data-manufacturer="{{ $vehicle->manufacturer }}"
                                                                    data-model="{{ $vehicle->model }}"
                                                                    data-year="{{ $vehicle->year }}"
                                                                    data-color="{{ $vehicle->color }}"
                                                                    data-vehiclenumber="{{ $vehicle->vehicle_number }}"
                                                                    data-platenumber="{{ $vehicle->plate_number }}"
                                                                    data-chassisnumber="{{ $vehicle->chassis_number }}"
                                                                    data-enginenumber="{{ $vehicle->engine_number }}"
                                                                    data-seats="{{ $vehicle->seats }}"
                                                                    data-driver="{{ $vehicle->getdriver() }}"
                                                                    data-status="{{ ucwords($vehicle->status) }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>View
                                                                    Details</a>


                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item mb-2" href="#"
                                                                    data-bs-toggle="offcanvas" data-bs-target="#editVehicle"
                                                                    data-backdrop="static" data-backdrop="static"
                                                                    data-myid="{{ $vehicle->id }}"
                                                                    data-manufacturer="{{ $vehicle->manufacturer }}"
                                                                    data-model="{{ $vehicle->model }}"
                                                                    data-year="{{ $vehicle->year }}"
                                                                    data-color="{{ $vehicle->color }}"
                                                                    data-vehiclenumber="{{ $vehicle->vehicle_number }}"
                                                                    data-platenumber="{{ $vehicle->plate_number }}"
                                                                    data-chassisnumber="{{ $vehicle->chassis_number }}"
                                                                    data-enginenumber="{{ $vehicle->engine_number }}"
                                                                    data-seats="{{ $vehicle->seats }}"
                                                                    data-status="{{ ucwords($vehicle->status) }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>Edit
                                                                    Details</a>
                                                            </li>
                                                            <a class="dropdown-item mb-2" href="#"
                                                                data-bs-toggle="offcanvas" data-bs-target="#assignDriver"
                                                                data-backdrop="static" data-myid="{{ $vehicle->id }}"
                                                                data-driver="{{ $vehicle->driver }}"><i
                                                                    class="fe fe-eye dropdown-item-icon"></i>Assign
                                                                Driver</a>
                                                            @if ($vehicle->status == 'active')
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('superadmin.underMaintenance', [$vehicle->id]) }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Place
                                                                        Under
                                                                        Maintenance</a>
                                                                </li>
                                                            @endif

                                                            @if ($vehicle->status == 'under maintenance')
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('superadmin.activateVehicle', [$vehicle->id]) }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Activate
                                                                        Vehicle</a>
                                                                </li>
                                                            @endif

                                                            @if ($vehicle->status == 'active' || $vehicle->status == 'under maintenance')
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('superadmin.vehicleDecommissioned', [$vehicle->id]) }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Mark As
                                                                        Decommissioned</a>
                                                                </li>
                                                            @endif

                                                            @if ($vehicle->status == 'active' || $vehicle->status == 'under maintenance' || $vehicle->status == 'decommissioned')
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('superadmin.vehicleSold', [$vehicle->id]) }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Mark
                                                                        As
                                                                        Sold</a>
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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Add New Vehicle</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form novalidate method="post" action="{{ route('superadmin.storeVehicleDetails') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>PMT Vehicle Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="vehicle_number" class="form-control"
                                placeholder="Enter PMT Number" required>
                            <div class="invalid-feedback">Please provide PMT Vehicle Number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Vehicle Manufacturer</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="manufacturer" class="form-control"
                                placeholder="Enter Vehicle Manufacturer" required>
                            <div class="invalid-feedback">Please provide vehicle manaufacturer.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Year Manufactured</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="year" class="form-control"
                                placeholder="Enter Year Manufactured" required>
                            <div class="invalid-feedback">Please provide year manufactured.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Vehicle Model</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="model" class="form-control" placeholder="Enter Vehicle Model"
                                required>
                            <div class="invalid-feedback">Please provide vehicle model.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Vehicle Color</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="color" class="form-control" placeholder="Enter Vehicle Color"
                                required>
                            <div class="invalid-feedback">Please provide vehicle color.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Plate Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="plate_number" class="form-control"
                                placeholder="Enter Plate Number" required>
                            <div class="invalid-feedback">Please provide plate number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Chassis Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="chassis_number" class="form-control"
                                placeholder="Enter Chassis Number" required>
                            <div class="invalid-feedback">Please provide chassis number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Engine Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="engine_number" class="form-control"
                                placeholder="Enter Engine Number" required>
                            <div class="invalid-feedback">Please provide engine number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Passenger Capacity (No. of seats)</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="passenger_capacity" class="form-control"
                                placeholder="Enter Passenger Capacity" required>
                            <div class="invalid-feedback">Please provide passenger capacity.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Add Vehicle To Fleet</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="vehicleDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        Vehicle Details
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class=""><strong>PMT Vehicle Number</strong></td>
                                <td class=""><span id="vvehiclenumber"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Vehicle Manufacturer:</strong></td>
                                <td class=""><span id="vmanufacturer"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Vehicle Model:</strong></td>
                                <td class=""><span id="vmodel"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Year of Manufacture:</strong></td>
                                <td class=""><span id="vyear"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Vehicle Color:</strong></td>
                                <td class=""><span id="vcolor"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Plate Number:</strong></td>
                                <td class=""><span id="vplatenumber"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Engine Number</strong></td>
                                <td class=""><span id="venginenumber"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Chassis Number</strong></td>
                                <td class=""><span id="vchassisnumber"></span></td>
                            </tr>

                            <tr>
                                <td class=""><strong>Passenger Capacity</strong></td>
                                <td class=""><span id="vseats"></span> Seater</td>
                            </tr>

                            <tr>
                                <td class=""><strong>Assigned Driver</strong></td>
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="editVehicle" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Update Vehicle Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('superadmin.updateVehicleDetails') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>PMT Vehicle Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="pmtno" type="text" name="vehicle_number" class="form-control"
                                placeholder="Enter PMT Number" required>
                            <div class="invalid-feedback">Please provide PMT Vehicle Number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Vehicle Manufacturer</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="manufacturer" type="text" name="manufacturer" class="form-control"
                                placeholder="Enter Vehicle Manufacturer" required>
                            <div class="invalid-feedback">Please provide vehicle manaufacturer.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Year Manufactured</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="year" type="text" name="year" class="form-control"
                                placeholder="Enter Year Manufactured" required>
                            <div class="invalid-feedback">Please provide year manufactured.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Vehicle Model</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="model" type="text" name="model" class="form-control"
                                placeholder="Enter Vehicle Model" required>
                            <div class="invalid-feedback">Please provide vehicle model.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Vehicle Color</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="color" type="text" name="color" class="form-control"
                                placeholder="Enter Vehicle Color" required>
                            <div class="invalid-feedback">Please provide vehicle color.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Plate Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="plateno" type="text" name="plate_number" class="form-control"
                                placeholder="Enter Plate Number" required>
                            <div class="invalid-feedback">Please provide plate number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Chassis Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="chasno" type="text" name="chassis_number" class="form-control"
                                placeholder="Enter Chassis Number" required>
                            <div class="invalid-feedback">Please provide chassis number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Engine Number</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="engno" type="text" name="engine_number" class="form-control"
                                placeholder="Enter Engine Number" required>
                            <div class="invalid-feedback">Please provide engine number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Passenger Capacity (No. of seats)</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="seats" type="text" name="passenger_capacity" class="form-control"
                                placeholder="Enter Passenger Capacity" required>
                            <div class="invalid-feedback">Please provide passenger capacity.</div>
                        </div>

                        <input id="myid" type="hidden" name="vehicle_id" class="form-control" required>

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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="assignDriver" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Assign Driver</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('superadmin.assignDriver') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Assign Driver</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="driver" name="driver" class="form-select" data-width="100%" required>
                                <option value="all">Select Driver</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->last_name }}, {{ $driver->other_names }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select driver.</div>
                        </div>

                        <input id="myid" type="hidden" name="vehicle_id" class="form-control" required>

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
        document.getElementById("fleet").classList.add('active');
    </script>
@endsection
