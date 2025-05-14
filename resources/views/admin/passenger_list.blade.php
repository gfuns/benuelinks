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
                            <div style="max-width: 600px">
                                <table class="table mb-0 text-nowrap table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class=""><strong>Travel Date</strong></td>
                                            <td class="">
                                                <span>{{ date_format(new DateTime($travelSchedule->scheduled_date), 'l - jS M, Y') }}
                                                    {{ $travelSchedule->scheduled_time }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Travel Route</strong></td>
                                            <td class=""><span>{{ $travelSchedule->travelRoute() }}</span></td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Vehicle Details</strong></td>
                                            <td class="">
                                                <span>{{ preg_replace('/<br\s*\/?>/i', ' ', $travelSchedule->getvehicle()) }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class=""><strong>Driver Details</strong></td>
                                            <td class="">
                                                <span>{{ preg_replace('/<br\s*\/?>/i', ' ', $travelSchedule->getdriver()) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                            <hr />
                            <form method="POST" action="{{ route('admin.processPassengerBoarding') }}">
                                @csrf
                                <div class="d-flex align-items-center">

                                    <button type="submit" id="actionButton" style="display: none"
                                        class="btn btn-primary ms-auto btn-sm">
                                        <i class="fas fa-bus-alt"></i>
                                        Board Passengers
                                    </button>
                                </div>
                                <div class="table-responsive mt-4">

                                    <table id="pagedexample" class="table mb-0 text-nowrap table-hover table-centered">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input name="" class="form-check-input gfuns"
                                                        type="checkbox" id="selectAll"></th>
                                                <th scope="col">S/No.</th>
                                                <th scope="col">Booking Number</th>
                                                <th scope="col">Passenger Name</th>
                                                <th scope="col">Phone Number</th>
                                                <th scope="col">Seat Number</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($passengers as $pass)
                                                <tr>
                                                    <td class="align-middle">
                                                        <input name="selected_items[]" value="{{ $pass->id }}"
                                                            class="checkbox form-check-input gfuns" type="checkbox"
                                                            id="">
                                                    </td>
                                                    <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                                    <td class="align-middle"> {{ $pass->booking_number }} </td>
                                                    <td class="align-middle"> {{ $pass->full_name }} </td>
                                                    <td class="align-middle"> {{ $pass->phone_number }} </td>
                                                    <td class="align-middle"> Seat {{ $pass->seat }} </td>
                                                    <td>
                                                        @if ($pass->boarding_status == 'boarded')
                                                            <span class="badge badge-success p-2"
                                                                style="font-size: 10px">{{ ucwords($pass->boarding_status) }}</span>
                                                        @else
                                                            <span class="badge badge-warning p-2"
                                                                style="font-size: 10px">{{ ucwords($pass->boarding_status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        document.getElementById("boarding").classList.add('active');
    </script>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            function toggleButton() {
                if ($(".checkbox:checked").length > 0) {
                    $("#actionButton").show();
                } else {
                    $("#actionButton").hide();
                }
            }

            // When "Select All" is clicked
            $("#selectAll").click(function() {
                $(".checkbox").prop("checked", this.checked);
                toggleButton();
            });

            // When any checkbox is clicked
            $(".checkbox").click(function() {
                if ($(".checkbox:checked").length === $(".checkbox").length) {
                    $("#selectAll").prop("checked", true);
                } else {
                    $("#selectAll").prop("checked", false);
                }
                toggleButton();
            });
        });
    </script>
@endsection
