<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peace Mass Transit (PMT) | Passenger Manifest</title>

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
            padding-bottom: 20px;
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
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo"
                    style="max-width:200px; margin-bottom: 10px">
                <div class="title">
                    PASSENGER MANIFEST
                </div>
            </div>

        </div>

        <h6>SCHEDULE DETAILS</h6>
        <div style="max-width: 600px">
            <table class="table table-bordered" style="margin-bottom: 40px">
                <tbody>
                    <tr>
                        <td class=""><strong>Travel Date</strong></td>
                        <td class=""><span>{{ date_format(new DateTime($travelSchedule->scheduled_date), 'l - jS M, Y') }}
                            {{ $travelSchedule->scheduled_time }}</span></td>
                    </tr>

                    <tr>
                        <td class=""><strong>Travel Route</strong></td>
                        <td class=""><span>{{ $travelSchedule->travelRoute() }}</span></td>
                    </tr>

                    <tr>
                        <td class=""><strong>Vehicle Details</strong></td>
                        <td class=""><span>{{ preg_replace('/<br\s*\/?>/i', " ", $travelSchedule->getvehicle()) }}</span></td>
                    </tr>

                    <tr>
                        <td class=""><strong>Driver Details</strong></td>
                        <td class=""><span>{{ preg_replace('/<br\s*\/?>/i', " ", $travelSchedule->getdriver()) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Main Content (Table) -->
        <h6>PASSENGER LIST</h6>
        <table class="table">
            <thead class="">
                <tr>
                    <th>S/No.</th>
                    <th>Booking Number</th>
                    <th>Passenger Name</th>
                    <th>Phone Number</th>
                    <th>Seat Number</th>
                    <th>Emergency Contact</th>
                    <th>Contact's Phone No.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($passengers as $pass)
                    <tr>
                        <td> {{ $loop->index + 1 }} </td>
                        <td> {{ $pass->booking_number }} </td>
                        <td> {{ $pass->full_name }} </td>
                        <td> {{ $pass->phone_number }} </td>
                        <td> Seat {{ $pass->seat }} </td>
                        <td> {{ $pass->nok }} </td>
                        <td> {{ $pass->nok_phone }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
