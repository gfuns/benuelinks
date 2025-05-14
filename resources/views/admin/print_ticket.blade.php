<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peace Mass Transit (PMT) | Passenger Boarding Ticket</title>

    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Container styling */
        .container {
            /* max-width: 800px; */
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        /* Header section */
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2px;
            padding-bottom: 2px;
        }

        /* Image styling */
        .logo {
            max-height: 100px;
        }

        /* Title styling */
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* School info section */
        .info {
            text-align: left;
            font-size: 13px;
        }

        .info strong {
            display: inline-block;
            width: 130px;
            padding: 5px;
        }

        /* Dotted underline styling */
        .dotted-underline {
            text-decoration: underline;
            text-decoration-style: dotted;
            text-decoration-thickness: 2px;
            text-underline-offset: 3px;
            font-size: 13px;
        }

        /* Table styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            /* margin-top: 20px; */
            font-size: 12px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="header">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Logo" class="logo" style="max-width:200px; margin-bottom: 10px">
                <div class="title">
                    PASSENGER BOARDING TICKET
                </div>
            </div>

        </div>

        <!-- Main Content (Table) -->
        <table class="table table-bordered">
            <tbody>

                <tr>
                    <td class=""><strong>Booking Number</strong></td>
                    <td class=""><span>{{ $booking->booking_number }}</span></td>
                </tr>

                <tr>
                    <td class=""><strong>Travel Route:</strong></td>
                    <td class=""><span>{{ $booking->travelRoute() }}</span></td>
                </tr>

                <tr>
                    <td class=""><strong>Selected Vehicle:</strong></td>
                    <td class=""><span>{{ $booking->vehicle_type }}</span></td>
                </tr>

                <tr>
                    <td class=""><strong>Departure Date/Time:</strong></td>
                    <td class=""><span>{{ date_format(new DateTime($booking->travel_date), 'l jS M, Y') }}
                            {{ $booking->departure_time }}</span></td>
                </tr>

                <tr>
                    <td class=""><strong>Passenger Name:</strong></td>
                    <td class=""><span>{{ $booking->full_name }}</span></td>
                </tr>

                <tr>
                    <td class=""><strong>Passenger Phone Number:</strong></td>
                    <td class=""><span>{{ $booking->phone_number }}</span></td>
                </tr>

                <tr>
                    <td class=""><strong>Seat Number:</strong></td>
                    <td class=""><span>{{ $booking->seat }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
