@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">End Of Day Report</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <form method="get" action="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Travel Date</strong></label>
                                                <input type="date" name="travel_date" value="{{ $date }}"
                                                    max="{{ now()->toDateString() }}" class="form-control"
                                                    placeholder="Travel Date" onkeydown="return false"
                                                    onpaste="return false" ondrop="return false" required>

                                                @error('travel_date')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Travel Route</strong></label>
                                                <select id="fdestination" name="travel_route" class="form-select"
                                                    data-width="100%">
                                                    <option value="">All Routes</option>
                                                    @foreach ($travelRoutes as $trvroute)
                                                        <option value="{{ $trvroute->id }}"
                                                            @if ($trvroute->id == $route) selected @endif>
                                                            {{ $trvroute->departurePoint->terminal . ' => ' . $trvroute->destinationPoint->terminal }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('travel_route')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currentPassword"><strong>Tricketer</strong></label>
                                                <select id="event" name="ticketer" class="form-select"
                                                    data-width="100%">
                                                    <option value="">All Ticketers</option>
                                                    @foreach ($ticketers as $tikter)
                                                        <option value="{{ $tikter->id }}"
                                                            @if ($tikter->id == $ticketer) selected @endif>
                                                            {{ ucwords(strtolower($tikter->last_name . ' ' . $tikter->other_names)) }}
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
                            <h6 class="mt-4 mb-4"><strong>
                                    End Of Day Report For: {{ date_format(new DateTime($date), 'jS F, Y') }} @if (isset($routeData))
                                        ; Route:
                                        {{ $routeData->departurePoint->terminal . ' => ' . $routeData->destinationPoint->terminal }}
                                    @endif
                                    @if (isset($ticketerData))
                                        ; Ticketer:
                                        {{ ucwords(strtolower($ticketerData->last_name . ' ' . $ticketerData->other_names)) }}
                                    @endif
                                </strong></h6>

                            <div class="table-responsive">

                                <h6 class="mt-4"><strong>Ticket Sales Summary</strong></h6>

                                <table class="table table-bordered mb-0 text-nowrap" style="width: 60%">
                                    <tr>
                                        <th scope="col" style="font-size: 14px !important">Tickets Sold</th>
                                        <th scope="col" style="font-size: 14px !important">
                                            {{ number_format($params['tickets'], 0) }} Tickets</th>
                                    </tr>

                                    <tr>
                                        <th scope="col" style="font-size: 14px !important">Revenue Generated</th>
                                        <th scope="col" style="font-size: 14px !important">&#8358;
                                            {{ number_format($params['revenue'], 2) }}</th>
                                    </tr>
                                </table>
                            </div>

                            <div class="row mb-5">
                                <div class="col-12 col-md-6">
                                    <div class="table-responsive">

                                        <h6 class="mt-5"><strong>Booking Method Summary</strong></h6>

                                        <table class="table table-bordered mb-0 text-nowrap">
                                            <tr>
                                                <th scope="col" style="font-size: 14px !important">Online Booking</th>
                                                <td scope="col" style="font-size: 14px !important">
                                                    {{ number_format($params['onlinebooking'], 0) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="col" style="font-size: 14px !important">Physical Booking</th>
                                                <td scope="col" style="font-size: 14px !important">
                                                    {{ number_format($params['physicalbooking'], 0) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="col" style="font-size: 14px !important">Total Tickets</th>
                                                <th scope="col" style="font-size: 14px !important">
                                                    {{ number_format($totals['bookingmethod'], 0) }}
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="table-responsive">

                                        <h6 class="mt-5"><strong>Payment Channel Summary</strong></h6>

                                        <table class="table table-bordered mb-0 text-nowrap">
                                            <tr>
                                                <th scope="col" style="font-size: 14px !important">Fund Transfers</th>
                                                <td scope="col" style="font-size: 14px !important">&#8358;
                                                    {{ number_format($params['transfer'], 2) }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="col" style="font-size: 14px !important">Card Payments</th>
                                                <td scope="col" style="font-size: 14px !important">&#8358;
                                                    {{ number_format($params['card'], 2) }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="col" style="font-size: 14px !important">Wallet Payments</th>
                                                <td scope="col" style="font-size: 14px !important">&#8358;
                                                    {{ number_format($params['wallet'], 2) }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="col" style="font-size: 14px !important">Total Revenue</th>
                                                <th scope="col" style="font-size: 14px !important">&#8358;
                                                    {{ number_format($totals['paymentchannel'], 2) }}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>


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
        document.getElementById("eod").classList.add('active');
    </script>
@endsection
