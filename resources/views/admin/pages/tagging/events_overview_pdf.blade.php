<!DOCTYPE html>
<html>
<head>
    <title>Event Overview</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Event Overview</h1>
    <table>
        <thead>
            <tr>
                <h6>Barangay: {{ $barangay_name }}
                <h6>Precinct Number: {{ $precinct_number }}</h6>
            </tr>
            <tr>
                <th>No.</th>
                <th>Voters Name</th>
                {{-- <th>Barangay</th>
                <th>Precinct</th> --}}
                <th>Events Attended</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventoverviews as $index => $eventoverview)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $eventoverview->lastname }} {{ $eventoverview->firstname }} {{ $eventoverview->middlename }}</td>
                    {{-- <td>{{ $eventoverview->barangays->name }}</td>
                    <td>
                        @if ($eventoverview->precincts && $eventoverview->precincts->number)
                            {{ $eventoverview->precincts->number }}
                        @else
                            None
                        @endif
                    </td> --}}
                    <td>
                        @foreach ($eventoverview->eventtaggings as $eventtagging)
                            {{ $eventtagging->event->name }}<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
