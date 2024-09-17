<!DOCTYPE html>
<html>
<head>
    <title>Barangay Summary PDF</title>
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
        .header{
            text-align: center;
            position: fixed;
            width: 100%;
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
        <h1>Barangay Summary</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Barangay</th>
                    <th>Barangay Leader</th>
                    <th>Purok Leader</th>
                    <th>Down Line</th>
                    <th>Total</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangays as $item)
                    <tr>
                        <td>{{ $item['barangay'] }}</td>
                        <td>{{ $item['barangayLeaders'] }}</td>
                        <td>{{ $item['purokLeaders'] }}</td>
                        <td>{{ $item['downLine'] }}</td>
                        <td>{{ $item['totalLeadersAndDownline'] }} / {{ $item['total'] }}</td>
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
