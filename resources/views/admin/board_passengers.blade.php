@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Board Passengers</h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="pagedexample" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Travel Route</th>
                                            <th scope="col">Assigned Vehicle</th>
                                            <th scope="col">Departure Date/Time</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($travelSchedules as $schedule)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $schedule->travelRoute() }} </td>
                                                <td class="align-middle">@php echo $schedule->getvehicle() @endphp</td>
                                                <td class="align-middle">
                                                    {{ date_format(new DateTime($schedule->scheduled_date), 'l - jS M, Y') }}
                                                    {{ $schedule->scheduled_time }}
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
                                                                <a class="dropdown-item mb-2"
                                                                    href="{{ route('admin.viewPassengers', [$schedule->id]) }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>View
                                                                    Passengers</a>
                                                            </li>

                                                            <li>
                                                                <a class="dropdown-item mb-2"
                                                                    href="{{ route('admin.printPassengerManifest', [$schedule->id]) }}" target="_blank"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>Print Passenger
                                                                    Manifest</a>
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
        document.getElementById("boarding").classList.add('active');
    </script>
@endsection
