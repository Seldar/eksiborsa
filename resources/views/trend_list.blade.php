@extends('layouts.app')
@section('content')
    <script src="../node_modules/highcharts/js/highcharts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../node_modules/highcharts/css/highcharts.css" type="text/css">
<div class="container">
    <form action="" method="get" enctype="application/x-www-form-urlencoded">
        Start Date: <input type="date" name="startDate" value="{{ app('request')->input('startDate') }}"> <br>
        End Date: <input type="date" name="endDate" value="{{ app('request')->input('endDate') }}"> <br>
        Eksici: <input type="text" name="eksici" value="{{ app('request')->input('eksici') }}"> <br>
        Top: <select name="topX">
            <option value="10" @if(app('request')->input('topX') == 10) selected @endif>10</option>
            <option value="50" @if(app('request')->input('topX') == 50) selected @endif>50</option>
            <option value="100" @if(app('request')->input('topX') == 100) selected @endif>100</option>
        </select>
        <input type="submit" name="submit" value="Submit">
    </form>
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
                    text: 'Karma'
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
                        text: 'Trend'
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
