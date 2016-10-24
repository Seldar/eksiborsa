@extends('layouts.app')
@section('content')
    <script src="../node_modules/highcharts/js/highcharts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../node_modules/highcharts/css/highcharts.css" type="text/css">
<div class="container">
    <div id="container" style="width:100%; height:400px;"></div>
    <div id="container2" style="width:100%; height:400px;"></div>
</div>
    <script language="JavaScript">
        $(function () {
            myChart = Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Trends'
                },
                xAxis: {
                    categories: [@foreach($dates as $date => $x)'{{$date}}', @endforeach]
                },
                yAxis: {
                    title: {
                        text: 'Karma'
                    }
                },
                series: [
                        @foreach($data as $nick => $trend)
                    {
                        name: '{{$nick}}',
                        data: [
                            @foreach($trend as $value)
                            {{$value}},
                            @endforeach
                        ]
                    },
                    @endforeach
                ]
            });

            myChart = Highcharts.chart('container2', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Trends'
                },
                xAxis: {
                    categories: [@foreach($dates as $date => $x)'{{$date}}', @endforeach]
                },
                yAxis: {
                    title: {
                        text: 'Karma'
                    }
                },
                series: [
                        @foreach($karmaTrends as $nick => $trend)
                    {
                        name: '{{$nick}}',
                        data: [
                            @foreach($trend as $value)
                            {{$value}},
                            @endforeach
                        ]
                    },
                    @endforeach
                ]
            });
        });
    </script>
@endsection