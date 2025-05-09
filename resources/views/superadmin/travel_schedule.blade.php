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
                                                    data-width="100%" required>
                                                    <option value="all">All Terminals</option>
                                                    @foreach ($terminals as $dp)
                                                        <option value="{{ $dp->id }}">
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
                                                    data-width="100%" required>
                                                    <option value="all">All Terminals</option>
                                                    @foreach ($terminals as $destination)
                                                        <option value="{{ $destination->id }}">{{ $destination->terminal }}
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
                                                <input type="date" name="scheduled_date" class="form-control"
                                                    placeholder="End Date">

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

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Take-off Point</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Assigned Vehicle</th>
                                            <th scope="col">Time of Departure</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                        </tr>

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
        document.getElementById("schedules").classList.add('active');
    </script>
@endsection
