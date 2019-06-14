@extends('layouts.app')

@section('css')
    <!-- Morris Charts CSS -->
    <link href="{{ asset('vendor/morrisjs/morris.css') }}" rel="stylesheet">
@endsection

@section('content')
    @foreach($data as $dt)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 id="name-{{$dt}}"></h4>
            </div>
            <div class="row">
                <div class="panel-body">
                    <div class="col-lg-3">
                        <h4>{{date('M Y', strtotime('-3 Month'))}}</h4>
                        <div id="morris-donut-chart-3-{{$dt}}"></div>
                        <text class="hidden">{{$dt}}</text>
                    </div>
                    <div class="col-lg-3">
                        <h4>{{date('M Y', strtotime('-2 Month'))}}</h4>
                        <div id="morris-donut-chart-2-{{$dt}}"></div>
                    </div>
                    <div class="col-lg-3">
                        <h4>{{date('M Y', strtotime('-1 Month'))}}</h4>
                        <div id="morris-donut-chart-1-{{$dt}}"></div>
                    </div>
                    <div class="col-lg-3">
                        <h4>{{date('M Y')}}</h4>
                        <div id="morris-donut-chart-0-{{$dt}}"></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('js')
    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('vendor/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('vendor/morrisjs/morris.min.js')}}"></script>
    <script src="{{ asset('js/data/morris-data.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('.hidden').each(function(i, obj) {
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    contentType: 'application/json',
                    url: 'payment/'+obj.textContent,
//                    data: '{}',
                    success: function (response) {
                        Morris.Donut({
                            element: 'morris-donut-chart-3-'+obj.textContent,
                            data: response[3],
                            resize: true
                        });
                        Morris.Donut({
                            element: 'morris-donut-chart-2-'+obj.textContent,
                            data: response[2],
                            resize: true
                        });
                        Morris.Donut({
                            element: 'morris-donut-chart-1-'+obj.textContent,
                            data: response[1],
                            resize: true
                        });
                        Morris.Donut({
                            element: 'morris-donut-chart-0-'+obj.textContent,
                            data: response[0],
                            resize: true
                        });
                        $('#name-'+obj.textContent).text(response['name'])
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

        });

    </script>
@endsection