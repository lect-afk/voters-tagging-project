<!DOCTYPE html>
<html>
<head>
    <title>Alliance Tagging Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 8px;
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
    <div style="text-align: right">
        <h4>
            Total Allied: {{ $totalAllied }} out of {{ $totalVotes }} 
            <span class="{{ $totalPercentage < 50 ? 'percentage' : '' }}">
                ({{ number_format($totalPercentage, 1) }}%)
            </span>
        </h4>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Barangay</th>
                <th>Allied</th>
                <th>Prospective Ally</th>
                <th>Tentative Ally</th>
                <th>Non-Participant</th>
                <th>Non-Supporter</th>
                <th>Unilateral</th>
                <th>Unidentified</th>
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
                    <td>{{ $item['prospectiveally'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['prospectiveally'] / $item['total']) * 100, 1) }}%)</td>
                    <td>{{ $item['unlikelyally'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['unlikelyally'] / $item['total']) * 100, 1) }}%)</td>
                    <td>
                        {{ $item['nonparticipant'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['nonparticipant'] / $item['total']) * 100, 1) }}%)
                    </td>
                    <td>
                        {{ $item['nonsupporter'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['nonsupporter'] / $item['total']) * 100, 1) }}%)
                    </td>
                    <td>
                        {{ $item['inc'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['inc'] / $item['total']) * 100, 1) }}%)
                    </td>
                    <td>
                        {{ $item['unidentified'] }} / {{ $item['total'] }}
                        ({{ number_format(($item['unidentified'] / $item['total']) * 100, 1) }}%)
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
    </div>
</body>
</html>
