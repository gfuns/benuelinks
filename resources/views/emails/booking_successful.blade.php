<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            max-width: 150px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #f5f5f5;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #888;
            font-size: 12px;
            border-top: 1px solid #ddd;
        }

        .social-media {
            margin-top: 10px;
        }

        .social-media a {
            display: inline-block;
            margin-right: 10px;
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-media a:hover {
            color: #33cc66;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="{{ $message->embed(public_path('images/logo.png')) }}"
                alt="{{ env('APP_NAME') }} Logo">
        </div>

        <h2>Booking Successful</h2>

        <p>Dear {{ $booking->full_name}}</p>

        <p>Your trip was booked successful. Here are the transaction details:</p>

        <table>
            <tbody>
                <tr>
                    <th>Booking No</th>
                    <td>{{ $booking->booking_number }}</td>
                </tr>
                <tr>
                    <th>Take-off Point</th>
                    <td>{{ $booking->departurePoint->terminal }}</td>
                </tr>
                <tr>
                    <th>Destination</th>
                    <td>{{ $booking->destinationPoint->terminal }}</td>
                </tr>
                <tr>
                    <th>Travel Date</th>
                    <td>{{ date_format(new DateTime($booking->travel_date), 'l - jS M, Y') }}</td>
                </tr>
                <tr>
                    <th>Departure Time</th>
                    <td>{{ $booking->departure_time }}</td>
                </tr>
                <tr>
                    <th>Seat Number</th>
                    <td>Seat {{ $booking->seat }}</td>
                </tr>
                <tr>
                    <th>Travel Fare</th>
                    <td>&#8358;{{ number_format($booking->travel_fare, 2) }}</td>
                </tr>
                <tr>
                    <th>Cash Back</th>
                    <td>&#8358;{{ number_format(0, 2) }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>&#8358;{{ number_format($booking->travel_fare, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p>If you have any questions or need further assistance, please feel free to contact our support team.</p>

        <div class="">
            <p>Best regards,<br>Peace Mass Transit Team</p>
        </div>


    </div>
</body>

</html>
