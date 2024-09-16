<!DOCTYPE html>
<html>
<head>
    <title>Barangay Summary PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    <div class="container">
        <h1>Barangay Summary</h1>
        <table>
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
                        <td>{{ number_format($item['percentage'], 1) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
