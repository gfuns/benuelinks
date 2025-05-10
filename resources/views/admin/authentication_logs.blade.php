@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">User Authentication Report</div>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('admin.searchUserAuths') }}">
                                    @csrf

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Terminal</strong></label>
                                                <select id="fterminal" name="terminal" class="form-select" data-width="100%"
                                                    required>
                                                    <option value="null">All Terminals</option>
                                                    @foreach ($terminals as $dp)
                                                        <option value="{{ $dp->id }}" @if($terminal == $dp->id) selected @endif>
                                                            {{ $dp->terminal }}</option>
                                                    @endforeach
                                                </select>

                                                @error('terminal')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Event Type</strong></label>
                                                <select id="event" name="event_type" class="form-select"
                                                    data-width="100%" required>
                                                    <option value="null">Select Event Type</option>
                                                    <option value="null">All Events</option>
                                                    <option value="Login" @if($event == "Login") selected @endif>User Login</option>
                                                    <option value="Logout" @if($event == "Logout") selected @endif>User Logout</option>
                                                </select>

                                                @error('event_type')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Start Date</strong></label>
                                                <input type="date" name="start_date" class="form-control"
                                                    placeholder="Start Date">

                                                @error('start_date')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>End Date</strong></label>
                                                <input type="date" name="end_date" class="form-control"
                                                    placeholder="End Date">

                                                @error('end_date')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-2 filterButton">
                                            <button type="submit" class="btn btn-primary btn-md">Filter Report</button>
                                        </div>
                                    </div>


                                </form>
                            </div>


                            <hr />
                            <h6 class="mt-4 mb-4 ms-4"><strong>
                                    User {{ ucwords(isset($eventType) ? $eventType : 'Login And Logout') }} Activities For
                                    {{ isset($station) ? $station->terminal . ' Terminal' : 'All Terminals' }}
                                    @if (isset($startDate) && isset($endDate))
                                        Between:
                                        {{ date_format($startDate, 'jS M, Y') }} And
                                        {{ date_format($endDate, 'jS M, Y') }}
                                    @endif
                                </strong></h6>
                            <div class="table-responsive mb-5" style="padding-bottom: 100px">
                                <table class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <td class="th">S/No.</td>
                                            <td class="th">Surname</td>
                                            <td class="th">Other Names</td>
                                            <td class="th">Station</td>
                                            <td class="th">User Role</td>
                                            <td class="th">Event Type</td>
                                            <td class="th">Activity Date</td>
                                            <td class="th">Action</td>
                                        </tr>
                                    </thead>
                                    @if (isset($activities))
                                        <tbody>

                                            @foreach ($activities as $act)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $act->user->last_name }}</td>
                                                    <td>{{ $act->user->other_names }}</td>
                                                    <td>{{ $act->terminal->terminal }}</td>
                                                    <td>{{ $act->user->userRole->role }}</td>
                                                    <td>{{ $act->event }}</td>
                                                    <td>{{ date_format($act->created_at, 'jS M, Y g:ia') }}</td>
                                                    <td class="align-middle">
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#viewAuthDetails"
                                                            data-backdrop="static" data-myid="{{ $act->id }}"
                                                            data-surname="{{ $act->user->last_name }}"
                                                            data-othernames="{{ $act->user->other_names }}"
                                                            data-terminal="{{ $act->terminal->terminal }}"
                                                            data-role="{{ $act->user->userRole->role }}"
                                                            data-event="{{ $act->event }}"
                                                            data-description="{{ $act->description }}"
                                                            data-ip="{{ $act->ip_address }}"
                                                            data-agent="{{ $act->user_agent }}"
                                                            data-datecreated="{{ date_format($act->created_at, 'jS F, Y g:ia') }}">View
                                                            Details</button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="viewAuthDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        View Authentication Log Details
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="">Surname</td>
                                <td class=""><span id="vsurname"></span></td>
                            </tr>

                            <tr>
                                <td class="">Other Names</td>
                                <td class=""><span id="vothernames"></span></td>
                            </tr>

                            <tr>
                                <td class="">Station</td>
                                <td class=""><span id="vstation"></span></td>
                            </tr>

                            <tr>
                                <td class="">User Role</td>
                                <td class=""><span id="vrole"></span></td>
                            </tr>

                            <tr>
                                <td class="">Event Type</td>
                                <td class=""><span id="vevent"></span></td>
                            </tr>

                            <tr>
                                <td class="" style="white-space: nowrap">Event Description</td>
                                <td class=""><span id="vdescription"></span></td>
                            </tr>

                            <tr>
                                <td class="">IP Address</td>
                                <td class=""><span id="vip"></span></td>
                            </tr>

                            <tr>
                                <td class="">User Agent</td>
                                <td class=""><span id="vagent"></span></td>
                            </tr>

                            <tr>
                                <td class="">Activity Date</td>
                                <td class="" colspan="2"><span id="vdatecreated"></span></td>
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
        document.getElementById("adminreports").classList.add('active');
        document.getElementById("reports").classList.add('show');
        document.getElementById("authlogs").classList.add('active');
    </script>
@endsection
