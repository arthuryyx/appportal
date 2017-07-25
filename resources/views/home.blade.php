@extends('layouts.app')

@section('css')
    <!-- Morris Charts CSS -->
    <link href="{{ asset('vendor/morrisjs/morris.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
{{--<div class="row">--}}
    {{--<div class="col-lg-3 col-md-6">--}}
        {{--<div class="panel panel-primary">--}}
            {{--<div class="panel-heading">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xs-3">--}}
                        {{--<i class="fa fa-comments fa-5x"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-right">--}}
                        {{--<div class="huge">26</div>--}}
                        {{--<div>New Comments!</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<a href="#">--}}
                {{--<div class="panel-footer">--}}
                    {{--<span class="pull-left">View Details</span>--}}
                    {{--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-6">--}}
        {{--<div class="panel panel-green">--}}
            {{--<div class="panel-heading">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xs-3">--}}
                        {{--<i class="fa fa-tasks fa-5x"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-right">--}}
                        {{--<div class="huge">12</div>--}}
                        {{--<div>New Tasks!</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<a href="#">--}}
                {{--<div class="panel-footer">--}}
                    {{--<span class="pull-left">View Details</span>--}}
                    {{--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-6">--}}
        {{--<div class="panel panel-yellow">--}}
            {{--<div class="panel-heading">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xs-3">--}}
                        {{--<i class="fa fa-shopping-cart fa-5x"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-right">--}}
                        {{--<div class="huge">124</div>--}}
                        {{--<div>New Orders!</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<a href="#">--}}
                {{--<div class="panel-footer">--}}
                    {{--<span class="pull-left">View Details</span>--}}
                    {{--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-6">--}}
        {{--<div class="panel panel-red">--}}
            {{--<div class="panel-heading">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xs-3">--}}
                        {{--<i class="fa fa-support fa-5x"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-right">--}}
                        {{--<div class="huge">13</div>--}}
                        {{--<div>Support Tickets!</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<a href="#">--}}
                {{--<div class="panel-footer">--}}
                    {{--<span class="pull-left">View Details</span>--}}
                    {{--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<!-- /.row -->

<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Last 30 days Sales
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-line"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{date('M Y')}} Sales
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-donut-chart"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{date('M Y')}} Top Sales
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-bar-chart"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>

@endsection

@section('js')
    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('vendor/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('vendor/morrisjs/morris.min.js')}}"></script>
    <script src="{{ asset('js/data/morris-data.js')}}"></script>

    <script>
        $(document).ready(function(){
            $.ajax({
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json',
                url: 'statistics/salesBar',
                data: '{}',
                success: function (response) {
                    if(response.length == 0){
                        response.push({'y':'No Data'})
                    }
                    Morris.Bar({
                        element: 'morris-bar-chart',
                        data: response,
                        resize: true,
                        stacked: true,
                        xkey: 'y',
                        ykeys: ['a', 'b', 'c', 'd'],
                        labels: ['Pending', 'Ordered','Hold', 'Delivered'],
                        barColors: ['#F0AD4E', '#5BC0DE', '#5CB85C', '#337AB7']
                    });
                },

                error: function () {
                    alert("Error loading data! Please try again.");
                }
            });

            $.ajax({
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json',
                url: 'statistics/salesChart',
                data: '{}',
                success: function (response) {
                    if(response.length == 0){
                        response.push({'label':'No Data', 'value':0})
                    }

                    Morris.Donut({
                        element: 'morris-donut-chart',
                        data: response,
                        resize: true
//                        formatter: function (y, data) { return '$' + y }
                    });
                },

                error: function () {
                    alert("Error loading data! Please try again.");
                }
            });

            $.ajax({
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json',
                url: 'statistics/salesLine',
                data: '{}',
                success: function (response) {
                    Morris.Line({
                        element: 'morris-line',
                        data: response,
                        resize: true,
                        xkey: 'y',
                        ykeys: ['a', 'b'],
                        labels: ['Sub Total', 'Deposit']
                    });
                },

                error: function () {
                    alert("Error loading data! Please try again.");
                }
            });
        })

    </script>
@endsection
