@extends('layouts.app')
@section('content')
    <script src="../node_modules/highcharts/js/highcharts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<div class="container">
    <div id="container" style="width:100%; height:400px;"></div>
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
        });
    </script>
@endsection
