@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Travel Schedule</h4>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('superadmin.searchTravelSchedule') }}">
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

                                                            @if ($schedule->status == 'in transit' || $schedule->status == 'trip successful')
                                                                <li>
                                                                    <a class="dropdown-item mb-2"
                                                                        href="{{ route('superadmin.printPassengerManifest', [$schedule->id]) }}"
                                                                        target="_blank"><i
                                                                            class="fe fe-eye dropdown-item-icon"></i>View
                                                                        Passenger Manifest</a>
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


    <script type="text/javascript">
        document.getElementById("schedules").classList.add('active');
    </script>
@endsection
