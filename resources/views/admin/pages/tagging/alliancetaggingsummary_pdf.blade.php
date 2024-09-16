<!DOCTYPE html>
<html>
<head>
    <title>Alliance Tagging Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-danger {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Alliance Tagging Summary</h1>
    @php
        $totalAllied = 0;
        $totalVotes = 0;
        foreach ($barangay as $item) {
            $totalAllied += $item['allied'];
            $totalVotes += $item['total'];
        }
        $totalPercentage = ($totalAllied / $totalVotes) * 100;
    @endphp
    <h4>
        Total Allied: {{ $totalAllied }} out of {{ $totalVotes }} 
        <span class="{{ $totalPercentage < 50 ? 'text-danger' : '' }}">
            ({{ number_format($totalPercentage, 1) }}%)
        </span>
    </h4>

    <table>
        <thead>
            <tr>
                <th>Barangay</th>
                <th>Allied</th>
                <th>Hard Core</th>
                <th>Undecided</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangay as $item)
                @php
                    $percentage = ($item['allied'] / $item['total']) * 100;
                @endphp
                <tr>
                    <td>{{ $item['barangay'] }}</td>
                    <td class="{{ $percentage < 50 ? 'text-danger' : '' }}">
                        {{ $item['allied'] }} / {{ $item['total'] }} 
                        ({{ number_format($percentage, 1) }}%)
                    </td>
                    <td>
                        {{ $item['hardcore'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['hardcore'] / $item['total']) * 100, 1) }}%)
                    </td>
                    <td>
                        {{ $item['undecided'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['undecided'] / $item['total']) * 100, 1) }}%)
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
