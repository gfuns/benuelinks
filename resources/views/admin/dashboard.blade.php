@extends('admin.layouts.app')
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
                                    <h4 class="card-title" style="font-size:18px">0</h4>
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
                                    <h4 class="card-title" style="font-size:18px">{{ number_format(0, 0) }}</h4>
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
                                    <p class="card-category text-dark"><strong>Trips Completed</strong></p>
                                    <h4 class="card-title" style="font-size:18px">{{ number_format(0, 0) }}</h4>
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
                                    <h4 class="card-title" style="font-size:18px">{{ number_format(0, 0) }}</h4>
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
                        <div class="card-title" style="font-size: 14px">Scheduled Trips</div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table mb-0 text-nowrap table-hover table-centered">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th scope="col">S/No.</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Route</th>
                                        <th scope="col">Vehicle No.</th>
                                        <th scope="col">Driver</th>
                                        <th scope="col">Passengers</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

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

        var myLineChart = new Chart(lineChart, {
            type: "line",
            data: {
                labels: [
                    "Day 1",
                    "Day 2",
                    "Day 3",
                    "Day 4",
                    "Day 5",
                    "Day 6",
                    "Day 7",
                ],
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
                    data: [
                        542, 480, 430, 550, 530, 453, 380,
                    ],
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

        var myBarChart = new Chart(barChart, {
            type: "bar",
            data: {
                labels: [
                    "Lagos - Abuja",
                    "Abuja - Awka",
                    "Lagos - Awka",
                    "Abuja - Lagos",
                    "Abuja - Owerri",
                ],
                datasets: [{
                    label: "Tickets Sold",
                    backgroundColor: "rgb(23, 125, 255)",
                    borderColor: "rgb(23, 125, 255)",
                    data: [3, 2, 9, 5, 4],
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
