@extends('layouts.backend')

@section('content')
<div class="container">
    <div id="chart_div" style="width: 100%; height: 1000px;"></div>
</div>

<style>
    #chart_div {
        position: relative;
        height: 1000px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/echarts@latest/dist/echarts.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var chart = echarts.init(document.getElementById('chart_div'));

        // Example data structure
        var hierarchy = @json($hierarchy);

        function buildChartData(node) {
            var data = {
                name: node.name,
                alliance_status: node.alliance_status,
                leader_type: node.leader_type,
                precinct: node.precinct,
                label: {
                    rich: {
                        name: {
                            color: '#fff',
                            backgroundColor: getAllianceColor(node.alliance_status),
                            padding: [5, 10],
                            borderRadius: 5,
                            fontSize: 14,
                            align: 'center'
                        }
                    },
                    formatter: '{name|{b}}',
                },
                children: []
            };

            if (node.children) {
                node.children.forEach(child => {
                    data.children.push(buildChartData(child));
                });
            }

            return data;
        }

        function getAllianceColor(status) {
            switch (status) {
                case 'Green':
                    return '#0466c8';
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

        var chartData = buildChartData(hierarchy);

        var option = {
            tooltip: {
                trigger: 'item',
                triggerOn: 'mousemove',
                formatter: function(params) {
                    return params.data.name + '<br>' +
                           'Precinct: ' + (params.data.precinct || 'No Purok/Precinct') + '<br>' +
                           'Leader Type: ' + (params.data.leader_type || 'N/A');
                }
            },
            series: [
                {
                    type: 'tree',
                    data: [chartData],
                    orient: 'horizontal',
                    symbol: 'circle',  // Changed to a simple circle symbol
                    symbolSize: [30, 30],  // Adjust size to fit content better
                    label: {
                        position: 'inside',
                        formatter: '{name|{b}}',
                        rich: {
                            name: {
                                backgroundColor: 'transparent', // Remove any extra background color
                                padding: [5, 10],
                                borderRadius: 5,
                                fontSize: 14,
                                align: 'center'
                            }
                        }
                    },
                    lineStyle: {
                        color: '#007bff',
                        width: 2
                    },
                    emphasis: {
                        itemStyle: {
                            color: '#f0f0f0'
                        },
                        label: {
                            color: '#000',
                            fontSize: 16
                        }
                    }
                }
            ]
        };

        chart.setOption(option);
    });
</script>
@endsection
