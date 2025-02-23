<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Precinct Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .percentage {
            color: red;
        }
        .footer {
            bottom: 0;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Precinct Summary</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Precinct</th>
                    <th>Barangay</th>
                    <th>Total Leaders and Downline</th>
                    <th>Total Voters</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($precincts as $item)
                    <tr>
                        <td>{{ $item['precinct'] }}</td>
                        <td>{{ $item['barangay'] }}</td>
                        <td>{{ $item['totalLeadersAndDownline'] }}</td>
                        <td>{{ $item['total'] }}</td>
                        <td class="{{ $item['percentage'] < 50 ? 'percentage' : '' }}">
                            {{ number_format($item['percentage'], 1) }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
    </div>
</body>
</html>
