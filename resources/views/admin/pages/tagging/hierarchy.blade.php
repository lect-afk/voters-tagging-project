@extends('layouts.backend')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Organizational Chart</h1>
    </div>
        <div id="chart_div" style="width: 100%; height: 1000px;"></div>
</div>
<style>
    .google-visualization-orgchart-node {
        border: 1px solid #ccc;
        background-color: #f5f5f5;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .google-visualization-orgchart-linebottom {
        border-color: #007bff;
    }
    .google-visualization-orgchart-lineright {
        border-color: #007bff;
    }
    .google-visualization-orgchart-lineleft {
        border-color: #007bff;
    }
    .google-visualization-orgchart-linetop {
        border-color: #007bff;
    }
    .node-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .node-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
    }
    .name-with-color {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        border-radius: 5px;
    }
    .name-text {
        margin: 0;
        font-weight: bold;
    }
</style>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'Tooltip');

        // Recursively build the rows
        function buildRows(node, parentName = null) {
            var allianceColor = getAllianceColor(node.alliance_status);
            var nodeHtml = '<div class="node-content">' +
                            '<div class="node-header">' +
                            '<div class="name-with-color" style="background-color: ' + allianceColor + ';">' +
                            '<span class="name-text">' + node.name + '</span>' +
                            '</div>' +
                            '<div style="margin-top: 5px;">' + node.precinct + '</div>' +
                            '</div>' +
                           '</div>';
            var tooltip =  (node.precinct || 'No Purok/Precinct') + '\nAlliance: ' + node.alliance_status;
            data.addRow([{v: node.name, f: nodeHtml}, parentName, tooltip]);
            if (node.children) {
                node.children.forEach(child => buildRows(child, node.name));
            }
        }

        function getAllianceColor(status) {
            switch (status) {
                case 'Green':
                    return '#70e000';
                case 'Yellow':
                    return '#ffd60a';
                case 'Orange':
                    return '#fb8500';
                case 'Red':
                    return '#d00000';
                default:
                    return '#6c757d'; // Default color for unknown status
            }
        }

        // Starting with the top-level node
        var hierarchy = @json($hierarchy);
        buildRows(hierarchy);

        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        chart.draw(data, {allowHtml:true, size: 'medium'});
    }
</script>
@endsection
