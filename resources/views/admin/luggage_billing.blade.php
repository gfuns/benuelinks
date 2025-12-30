@extends('admin.layouts.app')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Extra Luggage Billing</div>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.updatePassword') }}">
                                @csrf

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bookingNumber"><strong>Booking Number</strong></label>
                                            <input type="text" name="booking_number" class="form-control"
                                                id="bookingNumber" placeholder="Booking Number" required />

                                            @error('booking_number')
                                                <span class="" role="alert">
                                                    <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card-action">
                                    <button type="submit" class="btn btn-primary">Verify Booking Details</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById("elb").classList.add('active');

    </script>
@endsection
