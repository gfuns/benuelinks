@extends('superadmin.layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Guest Virtual Accounts</h4>
                            </div>
                        </div>
                        <div class="card-body">


                            <div class="table-responsive">
                                <table class="table mb-0 text-nowrap table-hover table-centered">
                                    <thead>
                                        <tr>
                                            <td class="th">S/No.</td>
                                            <td class="th">Account Name</td>
                                            <td class="th">Account Number</td>
                                            <td class="th">Availability</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($guestAccounts as $ga)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $ga->last_name . ' ' . $ga->other_names }}</td>
                                                <td>{{ $ga->account_number }}</td>
                                                <td>
                                                    @if ($ga->availability == 1)
                                                        <span class="badge badge-success p-2"
                                                            style="font-size: 12px">Available</span>
                                                    @else
                                                        <span class="badge badge-warning p-2" style="font-size: 12px">In
                                                            Use</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if (count($guestAccounts) < 1)
                                            <tr>
                                                <td colspan="8">
                                                    <center>No Record Found</center>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if (count($guestAccounts) > 0 && $marker != null)
                            <div class="card-footer">
                                <div class="row g-2 pt-3 ms-4 me-4">
                                    <div class="col-md-9">Showing {{ $marker['begin'] }} to {{ $marker['end'] }}
                                        of
                                        {{ number_format($lastRecord) }} Records</div>

                                    <div class="col-md-3">{{ $guestAccounts->appends(request()->input())->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script type="text/javascript">
        document.getElementById("guestAcounts").classList.add('active');
    </script>
@endsection
