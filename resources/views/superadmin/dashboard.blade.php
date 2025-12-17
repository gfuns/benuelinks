@extends('superadmin.layouts.app')
@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">{{ Auth::user()->userRole->role }} Dashboard</h3>
                <h6 class="op-7 mb-2">Peace Mass Transit (PMT) > {{ Auth::user()->terminal->terminal }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark"><strong>Tickets Sold Today</strong></p>
                                    <h4 class="card-title" style="font-size:18px">{{ number_format($param['tickets'], 0) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark"><strong>Today's Revenue</strong></p>
                                    <h4 class="card-title" style="font-size:16px">
                                        &#8358;{{ number_format($param['revenue'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-bus"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark"><strong>Trips Completed Today</strong></p>
                                    <h4 class="card-title" style="font-size:18px">{{ number_format($param['trips'], 0) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark"><strong>Today's Passengers</strong></p>
                                    <h4 class="card-title" style="font-size:18px">
                                        {{ number_format($param['passengers'], 0) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 14px">Revenue Over Last 7 Days</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="lineChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="card card-stats card-round">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 14px">Tickets Sold</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12">
                <div class="card card-stats card-round">
                    <div class="card-header">
                        <div class="card-title" style="font-size: 14px">Today's Scheduled Trips</div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table mb-0 text-nowrap table-hover table-centered">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th scope="col">S/No.</th>
                                        <th scope="col">Travel Route</th>
                                        <th scope="col">Vehicle No.</th>
                                        <th scope="col">Driver</th>
                                        <th scope="col">Passengers</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scheduledTrips as $trip)
                                        <tr style="font-size: 12px">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $trip->travelRoute() }}</td>
                                            <td>@php echo $trip->getvehicle() @endphp</td>
                                            <td>@php echo $trip->getdriver() @endphp</td>
                                            <td>{{ $trip->passengers() }}</td>
                                            <td>
                                                @if ($trip->status == 'scheduled')
                                                    <span class="badge badge-warning p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'boarding in progress')
                                                    <span class="badge badge-info p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'trip suspended')
                                                    <span class="badge badge-danger p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'in transit')
                                                    <span class="badge badge-info p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @elseif ($trip->status == 'trip successful')
                                                    <span class="badge badge-success p-2"
                                                        style="font-size: 10px">{{ ucwords($trip->status) }}</span>
                                                @endif
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

    <script type="text/javascript">
        document.getElementById("dashboard").classList.add('active');
    </script>
@endsection

@section('customjs')
    <script>
        var lineChart = document.getElementById("lineChart").getContext("2d"),
            barChart = document.getElementById("barChart").getContext("2d");

        let lineLabels = @json($revennueStats["period"]);
        var myLineChart = new Chart(lineChart, {
            type: "line",
            data: {
                labels: lineLabels,
                datasets: [{
                    label: "Revenue Generated",
                    borderColor: "#1d7af3",
                    pointBorderColor: "#FFF",
                    pointBackgroundColor: "#1d7af3",
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 1,
                    pointRadius: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    borderWidth: 2,
                    data: [{{ $revennueStats["stats"] }}],
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                    labels: {
                        padding: 10,
                        fontColor: "#1d7af3",
                    },
                },
                tooltips: {
                    bodySpacing: 4,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest",
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10,
                },
                layout: {
                    padding: {
                        left: 15,
                        right: 15,
                        top: 15,
                        bottom: 15
                    },
                },
            },
        });

        let barLabels = @json($ticketsSold["topRoutes"]);
        var myBarChart = new Chart(barChart, {
            type: "bar",
            data: {
                labels: barLabels,
                datasets: [{
                    label: "Tickets Sold",
                    backgroundColor: "rgb(23, 125, 255)",
                    borderColor: "rgb(23, 125, 255)",
                    data: [{{ $ticketsSold["ticketSales"] }}],
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                    }, ],
                },
            },
        });
    </script>
@endsection
