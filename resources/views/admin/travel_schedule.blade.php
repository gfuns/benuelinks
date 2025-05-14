@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Travel Schedule</h4>
                                <button class="btn btn-primary btn-round ms-auto btn-sm" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight">
                                    <i class="fa fa-plus"></i>
                                    Create New Schedule
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('admin.searchTravelSchedule') }}">
                                    @csrf

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Take-off Point</strong></label>
                                                <select id="fdeparture" name="take_off_point" class="form-select"
                                                    data-width="100%">
                                                    <option value="null">All Terminals</option>
                                                    @foreach ($terminals as $dp)
                                                        <option value="{{ $dp->id }}"
                                                            @if ($dp->id == $departure) selected @endif>
                                                            {{ $dp->terminal }}</option>
                                                    @endforeach
                                                </select>

                                                @error('take_off_point')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Destination</strong></label>
                                                <select id="fdestination" name="destination" class="form-select"
                                                    data-width="100%">
                                                    <option value="null">All Terminals</option>
                                                    @foreach ($terminals as $destin)
                                                        <option value="{{ $destin->id }}"
                                                            @if ($destin->id == $destination) selected @endif>
                                                            {{ $destin->terminal }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('destination')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Scheduled Date</strong></label>
                                                <input type="date" name="scheduled_date" value="{{ $date }}"
                                                    class="form-control" placeholder="End Date">

                                                @error('scheduled_date')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-3 filterButton">
                                            <button type="submit" class="btn btn-primary btn-md">Filter Travel
                                                Schedule</button>
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
                                            <th scope="col">Take-off Point</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Assigned Vehicle</th>
                                            <th scope="col">Scheduled Date</th>
                                            <th scope="col">Time of Departure</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($travelSchedules as $schedule)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $schedule->departurePoint->terminal }} </td>
                                                <td class="align-middle">{{ $schedule->destinationPoint->terminal }}</td>
                                                <td class="align-middle">@php echo $schedule->getvehicle() @endphp</td>
                                                <td class="align-middle">
                                                    {{ date_format(new DateTime($schedule->scheduled_date), 'l - jS M, Y') }}
                                                </td>
                                                <td class="align-middle">{{ $schedule->scheduled_time }}</td>
                                                <td>
                                                    @if ($schedule->status == 'scheduled')
                                                        <span class="badge badge-warning p-2"
                                                            style="font-size: 10px">{{ ucwords($schedule->status) }}</span>
                                                    @elseif ($schedule->status == 'boarding in progress')
                                                        <span class="badge badge-info p-2"
                                                            style="font-size: 10px">{{ ucwords($schedule->status) }}</span>
                                                    @elseif ($schedule->status == 'trip suspended')
                                                        <span class="badge badge-danger p-2"
                                                            style="font-size: 10px">{{ ucwords($schedule->status) }}</span>
                                                    @elseif ($schedule->status == 'in transit')
                                                        <span class="badge badge-info p-2"
                                                            style="font-size: 10px">{{ ucwords($schedule->status) }}</span>
                                                    @elseif ($schedule->status == 'trip successful')
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 10px">{{ ucwords($schedule->status) }}</span>
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
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewScheduleDetails"
                                                                    data-backdrop="static" data-myid="{{ $schedule->id }}"
                                                                    data-departure="{{ $schedule->departurePoint->terminal }}"
                                                                    data-destination="{{ $schedule->destinationPoint->terminal }}"
                                                                    data-date="{{ date_format(new DateTime($schedule->scheduled_date), 'l - jS M, Y') }}"
                                                                    data-time="{{ $schedule->scheduled_time }}"
                                                                    data-vehicle="{{ $schedule->getvehicle() }}"
                                                                    data-driver="{{ $schedule->getdriver() }}"
                                                                    data-status="{{ ucwords($schedule->status) }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>View
                                                                    Details</a>
                                                            </li>

                                                            <li>
                                                                <a class="dropdown-item mb-2" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#updateTripStatus"
                                                                    data-backdrop="static"
                                                                    data-myid="{{ $schedule->id }}"
                                                                    data-status="{{ $schedule->status }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>Update
                                                                    Trip Status</a>
                                                            </li>

                                                            @if ($schedule->departure == Auth::user()->station && $schedule->status == 'scheduled')
                                                                <li>
                                                                    <a class="dropdown-item mb-2" href="#"
                                                                        data-bs-toggle="offcanvas"
                                                                        data-bs-target="#adjustDepartureTime"
                                                                        data-backdrop="static"
                                                                        data-myid="{{ $schedule->id }}"
                                                                        data-time="{{ $schedule->scheduled_time }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Adjust
                                                                        Departure
                                                                        Time</a>
                                                                </li>
                                                                <li>

                                                                    <a class="dropdown-item mb-2" href="#"
                                                                        data-bs-toggle="offcanvas"
                                                                        data-bs-target="#assignVehicle"
                                                                        data-backdrop="static"
                                                                        data-myid="{{ $schedule->id }}"
                                                                        data-vehicle="{{ $schedule->vehicle }}"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>Assign
                                                                        Vehicle</a>
                                                                </li>
                                                                <li>

                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.suspendTrip', [$schedule->id]) }}"
                                                                        onclick="return confirm('Are you sure you want to suspend this trip?');"><i
                                                                            class="fe fe-trash dropdown-item-icon"></i>Suspend
                                                                        Trip</a>
                                                                </li>
                                                            @endif
                                                            </li>
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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Travel Schedule</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('admin.storeTravelSchedule') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Destination</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="destination" name="destination" class="form-select" data-width="100%" required>
                                <option value="all">Select Destination</option>
                                @foreach ($terminals as $destination)
                                    <option value="{{ $destination->id }}">{{ $destination->terminal }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select destination.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Departure Time</strong> <span
                                    class="text-danger">*</span></label>
                            <input id="departureTime" type="text" name="departure_time" class="form-control"
                                placeholder="Select Departure Time" required style="border: 1px solid #cbd5e1 !important">
                            <div class="invalid-feedback">Please select departure time.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Schedule Configuration</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="scheduleConfig" name="schedule_configuration" class="form-select"
                                data-width="100%" required>
                                <option value="">Select Schedule Configuration</option>
                                <option value="specific" data-configtype="specific">Schedule for a specific date</option>
                                <option value="weekly" data-configtype="weekly">Schedule all through the week</option>
                                {{-- <option value="monthly"  data-configtype="monthly">Schedule all through the month</option> --}}
                            </select>
                            <div class="invalid-feedback">Please select schedule configuration.</div>
                        </div>

                        <div id="showDate" class="mb-3 col-12" style="display: none">
                            <label class="form-label"><strong>Scheduled Date</strong> <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="scheduled_date" min="{{ date('Y-m-d') }}" class="form-control"
                                placeholder="Enter Role" required>
                            <div class="invalid-feedback">Please select scheduled date.</div>
                        </div>

                        <div id="showWeek" class="mb-3 col-12" style="display: none">
                            <fieldset id="displayGrp" class="border rounded p-3 mb-5">
                                <legend class="float-none w-auto px-2">Select Days of the Week <span
                                        class="text-danger">*</span></legend>
                                <label class="form-label"><strong>{{ $weekData }}</strong> </label>
                                <div class="row mt-3">
                                    @foreach ($weekDates as $wd)
                                        <div class="col-md-3 col-3 mb-3">
                                            <div class="input-item input-with-label">
                                                <input class="gfuns input-checkbox input-checkbox-sm" name="week_date[]"
                                                    id="wd_{{ $loop->index }}" value="{{ $wd['date'] }}"
                                                    type="checkbox">
                                                <label for="wd_{{ $loop->index }}"><strong>{{ $wd['label'] }}</strong>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </fieldset>
                        </div>


                        <input type="hidden" name="take_off_point" value="{{ Auth::user()->station }}"
                            class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Travel Schedule</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="viewScheduleDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        Schedule Details
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


    <div class="offcanvas offcanvas-end" tabindex="-1" id="adjustDepartureTime" style="width: 600px;">
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="assignVehicle" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Assign Vehicle</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.assignVehicle') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label"><strong>Assign Vehicle</strong> <span
                                    class="text-danger">*</span></label>
                            <select id="vehicle" name="vehicle" class="form-select" data-width="100%" required>
                                <option value="all">Select Vehicle</option>
                                @foreach ($companyVehicles as $cv)
                                    <option value="{{ $cv->id }}">{{ $cv->vehicle_number }} -
                                        {{ $cv->manufacturer }} ({{ $cv->model }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select vehicle.</div>
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


    <div class="modal fade" id="updateTripStatus" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        Update Trip Status
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateTripStatus') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- form group -->
                            <div class="mb-3 col-12">
                                <label class="form-label"><strong>Trip Status</strong></label>
                                <select id="tripStatus" name="trip_status" class="form-select" data-width="100%">
                                    <option value="">Select Trip Status</option>
                                    <option value="boarding in progress">Boarding In Progress</option>
                                    <option value="in transit">Vehicle In Transit</option>
                                    <option value="trip successful">Trip Successful</option>
                                </select>
                                <div class="invalid-feedback">Please select trip status.</div>
                            </div>

                            <input id="myid" type="hidden" name="schedule_id" class="form-control" required>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Update Trip Status</button>
                        <button type="button" class="btn btn-outline-primary ms-2"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        document.getElementById("schedules").classList.add('active');
    </script>
@endsection

@section('customjs')
    <script>
        flatpickr("#departureTime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // "K" = AM/PM
            time_24hr: false,
            defaultHour: 6,
            defaultMinute: 30
        });

        flatpickr("#adepartureTime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // "K" = AM/PM
            time_24hr: false,
            defaultHour: 6,
            defaultMinute: 30
        });


        $("#scheduleConfig").change(function() {
            var selectedOption = this.options[this.selectedIndex];
            var config = selectedOption.getAttribute("data-configtype");

            if (config == "specific") {
                $("#showDate").css("display", "block");
                $("#showWeek").css("display", "none");
            } else if (config == "weekly") {
                $("#showDate").css("display", "none");
                $("#showWeek").css("display", "block");
            } else {
                $("#showDate").css("display", "none");
                $("#showWeek").css("display", "none");
            }
        });
    </script>
@endsection
