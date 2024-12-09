<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alliance Tagging PDF</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        .status-circle {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <h1>Alliance Tagging Report</h1>
    <p>Precinct: {{ $voters_profiles->first()->barangays->name ?? 'Unknown' }} {{ $precinct_number }}</p>
    <p>Alliance Status:
        @if ($alliance_status == 'Green')
            Ally
        @elseif ($alliance_status == 'Yellow')
            Prospective Ally
        @elseif ($alliance_status == 'Orange')
            Unlikely Ally
        @elseif ($alliance_status == 'None')
            Non-participant
        @elseif ($alliance_status == 'Red')
            Non-supporter
        @elseif ($alliance_status == 'White')
            Unilateral
        @elseif ($alliance_status == 'Black')
            Unidentified
        @endif
    </p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($voters_profiles as $voters_profile)
                @php
                    $backgroundColor = '#6c757d';
                    switch ($voters_profile->alliances_status) {
                        case 'Green':
                            $backgroundColor = '#0466c8';
                            break;
                        case 'Yellow':
                            $backgroundColor = '#ffd60a';
                            break;
                        case 'Orange':
                            $backgroundColor = '#99582a';
                            break;
                        case 'Red':
                            $backgroundColor = '#d00000';
                            break;
                        case 'White':
                            $backgroundColor = '#e0fbfc';
                            break;
                        case 'Black':
                            $backgroundColor = '#353535';
                            break;
                    }
                @endphp
                <tr>
                    <td>{{ $voters_profile->id }}</td>
                    <td>{{ $voters_profile->lastname }} {{ $voters_profile->firstname }} {{ $voters_profile->middlename }}</td>
            @endforeach
        </tbody>
    </table>
</body>
</html>
