@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Extra Luggages Transactions Report</div>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <form method="get" action="">

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Start Date</strong></label>
                                                <input type="date" name="start_date" class="form-control"
                                                    placeholder="Start Date" value="{{ $startDate }}">

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
                                                    placeholder="End Date" value="{{ $endDate }}">

                                                @error('end_date')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Terminal</strong></label>
                                                <select id="fterminal" name="terminal" class="form-select"
                                                    data-width="100%">
                                                    <option value="">All Terminals</option>
                                                    @foreach ($terminals as $dp)
                                                        <option value="{{ $dp->id }}"
                                                            @if ($terminal == $dp->id) selected @endif>
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Vehicle</strong></label>
                                                <select id="event" name="bus" class="form-select" data-width="100%">
                                                    <option value="">All Vehicles</option>
                                                    @foreach ($vehicles as $veh)
                                                        <option value="{{ $veh->id }}"
                                                            @if ($bus == $veh->id) selected @endif>
                                                            {{ $veh->manufacturer }} ({{ $veh->vehicle_number }})</option>
                                                    @endforeach
                                                </select>

                                                @error('bus')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Ticketer</strong></label>
                                                <select id="ticketer" name="ticketer" class="form-select"
                                                    data-width="100%">
                                                    <option value="">All Ticketers</option>
                                                    @foreach ($ticketers as $tker)
                                                        <option value="{{ $tker->id }}"
                                                            @if ($ticketer == $tker->id) selected @endif>
                                                            {{ ucwords(strtolower($tker->last_name . ' ' . $tker->other_names)) }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('ticketer')
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

                                    {{-- @if (isset($startDate) && isset($endDate))
                                        Filtered Transactions Report For The Period:
                                        {{ date_format(new DateTime($startDate), 'jS M, Y') }} And
                                        {{ date_format(new DateTime($endDate), 'jS M, Y') }}
                                    @endif --}}
                                </strong></h6>
                            <div class="table-responsive mb-5" style="padding-bottom: 100px">
                                <table class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <td class="th">S/No.</td>
                                            <td class="th">Transaction Date</td>
                                            <td class="th">Route</td>
                                            <td class="th">Passenger</td>
                                            <td class="th">Vehicle Details</td>
                                            <td class="th">Luggage Weight</td>
                                            <td class="th">Revenue Generated</td>
                                            <td class="th">Ticketer</td>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($transactions as $trx)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ date_format(new DateTime($trx->scheduled_date), 'l - jS M, Y') }}
                                                </td>
                                                <td>{{ $trx->booking->travelRoute() }}</td>
                                                <td>{{ $trx->booking->full_name }}</td>
                                                <td>
                                                    @if (isset($trx->booking->schedule->vehicledetail))
                                                        {{ $trx->booking->schedule->vehicledetail->manufacturer }}
                                                        ({{ $trx->booking->schedule->vehicledetail->vehicle_number }})
                                                    @else
                                                        Nil
                                                    @endif
                                                </td>
                                                <td>{{ number_format($trx->luggage_weight,2) }} KG</td>
                                                <td>&#8358;{{ number_format($trx->fee,2) }}</td>
                                                <td>{{ isset($trx->ticketerdetail) ? ucwords(strtolower($trx->ticketerdetail->last_name . ' ' . $trx->ticketerdetail->other_names)) : 'Nil' }}
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
        document.getElementById("adminreports").classList.add('active');
        document.getElementById("reports").classList.add('show');
        document.getElementById("luggages").classList.add('active');
    </script>
@endsection
