@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Travel Routes</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <th scope="col">S/No.</th>
                                            <th scope="col">Departure Point</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Transport Fare</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companyTravelRoutes as $route)
                                            <tr>
                                                <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                <td class="align-middle"> {{ $route->departurePoint->terminal }} </td>
                                                <td class="align-middle">{{ $route->destinationPoint->terminal }}</td>
                                                <td class="align-middle">&#8358;{{ number_format($route->transport_fare, 2) }}</td>
                                                <td>
                                                    @if ($route->status == 'active')
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 10px">{{ ucwords($route->status) }}</span>
                                                    @else
                                                        <span class="badge badge-warning p-2"
                                                            style="font-size: 10px">{{ ucwords($route->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    {{ date_format($route->created_at, 'jS F, Y') }}
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
        document.getElementById("routes").classList.add('active');
    </script>
@endsection
