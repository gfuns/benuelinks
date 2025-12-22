<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Peace Mass Transit | Boarding Ticket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 80mm;
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #000;
        }

        .container {
            padding: 5px 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 3px 0;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        tr.pad td {
            padding-bottom: 7px;
        }

        td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* td:first-child {
            width: 42%;
            font-weight: bold;
        }

        td:last-child {
            text-align: right;
            width: 58%;
        } */

        .footer {
            text-align: center;
            margin-top: 8px;
            border-top: 1px dashed #000;
            padding-top: 3px;
            font-size: 12px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                padding: 0 5px;
            }
        }
    </style>
</head>

<body onload="window.print();">
    <div class="container">
        <div class="header">
            <h2>Peace Xtra Comfort</h2>
            <div class="title">PASSENGER BOARDING TICKET</div>
        </div>


        <table>
            <tr>
                <td><strong>Booking Number:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->booking_number }}</td>
            </tr>
            <tr>
                <td><strong>Travel Route:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->travelRoute() }}</td>
            </tr>
            <tr>
                <td><strong>Vehicle:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->vehicle_type }}</td>
            </tr>
            <tr>
                <td><strong>Departure:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ date_format(new DateTime($booking->travel_date), 'l jS M, Y') }} {{ $booking->departure_time }}
                </td>
            </tr>
            <tr>
                <td><strong>Passenger:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->full_name }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->phone_number }}</td>
            </tr>
            <tr>
                <td><strong>Seat No.:</strong></td>
            </tr>
            <tr class="pad">
                <td>Seat {{ $booking->seat }}</td>
            </tr>
            <tr>
                <td><strong>Amount Paid:</strong></td>
            </tr>
            <tr class="pad">
                <td>&#8358; {{ number_format($booking->travel_fare, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Payment Channel:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ ucwords($booking->payment_channel) }}</td>
            </tr>
            <tr>
                <td><strong>Booking Method:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ ucwords($booking->booking_method) }} Booking</td>
            </tr>
        </table>

        <div class="footer">
            Thank you for choosing<br>
            Peace Xtra Comfort
        </div>
    </div>

    <div style="margin-bottom: 20px">&nbsp;</div>

    <div class="container">
        <div class="header">
            <h2>Peace Xtra Comfort</h2>
            <div class="title">CASHIER RECEIPT</div>
        </div>


        <table>
            <tr>
                <td><strong>Booking Number:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->booking_number }}</td>
            </tr>
            <tr>
                <td><strong>Travel Route:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->travelRoute() }}</td>
            </tr>
            <tr>
                <td><strong>Vehicle:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->vehicle_type }}</td>
            </tr>
            <tr>
                <td><strong>Departure:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ date_format(new DateTime($booking->travel_date), 'l jS M, Y') }} {{ $booking->departure_time }}
                </td>
            </tr>
            <tr>
                <td><strong>Passenger:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->full_name }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ $booking->phone_number }}</td>
            </tr>
            <tr>
                <td><strong>Seat No.:</strong></td>
            </tr>
            <tr class="pad">
                <td>Seat {{ $booking->seat }}</td>
            </tr>
            <tr>
                <td><strong>Amount Paid:</strong></td>
            </tr>
            <tr class="pad">
                <td>&#8358; {{ number_format($booking->travel_fare, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Payment Channel:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ ucwords($booking->payment_channel) }}</td>
            </tr>
            <tr>
                <td><strong>Booking Method:</strong></td>
            </tr>
            <tr class="pad">
                <td>{{ ucwords($booking->booking_method) }} Booking</td>
            </tr>
        </table>

        <div class="footer">
            Thank you for choosing<br>
            Peace Xtra Comfort
        </div>
    </div>
</body>

</html>
