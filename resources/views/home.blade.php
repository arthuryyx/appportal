@extends('layouts.app')

@section('css')
    <!-- Morris Charts CSS -->
    <link href="{{ asset('vendor/morrisjs/morris.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu1"><h4>Appliance</h4></a></li>
            <li><a data-toggle="tab" href="#menu2"><h4>Kitchen</h4></a></li>
        </ul>

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

<div class="tab-content">
    <div id="menu1" class="tab-pane fade in active">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                {{--<div class="panel-heading">--}}
                {{--{{date('M Y')}} Sales--}}
                {{--</div>--}}
                <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="col-lg-3">
                            <h4>{{date('M Y', strtotime('-3 Month'))}}</h4>
                            <div id="morris-donut-chart3"></div>
                            <h4 id="morris-donut-chart03"></h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>{{date('M Y', strtotime('-2 Month'))}}</h4>
                            <div id="morris-donut-chart2"></div>
                            <h4 id="morris-donut-chart02"></h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>{{date('M Y', strtotime('-1 Month'))}}</h4>
                            <div id="morris-donut-chart1"></div>
                            <h4 id="morris-donut-chart01"></h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>{{date('M Y')}}</h4>
                            <div id="morris-donut-chart0"></div>
                            <h4 id="morris-donut-chart00"></h4>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Last 3 Months
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="personal-morris-bar-chart"></div>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Last 30 days Sale & Payment
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="panel-body">
                        <div id="morris-area"></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div id="morris-donut-chart4"></div>
                </div>
            </div>
        </div>

            {{--<!-- /.row -->--}}
            {{--<div class="row">--}}
            {{--<div class="col-lg-12">--}}
            {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">--}}
            {{--{{date('M Y')}} Top Sales--}}
            {{--</div>--}}
            {{--<!-- /.panel-heading -->--}}
            {{--<div class="panel-body">--}}
            {{--<div id="morris-bar-chart"></div>--}}
            {{--</div>--}}
            {{--<!-- /.panel-body -->--}}
            {{--</div>--}}
            {{--<!-- /.panel -->--}}
            {{--</div>--}}
            {{--</div>--}}
    </div>
    <div id="menu2" class="tab-pane fade">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                {{--<div class="panel-heading">--}}
                {{--{{date('M Y')}} Sales--}}
                {{--</div>--}}
                <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="col-lg-3">
                            <h4>{{date('M Y', strtotime('-3 Month'))}}</h4>
                            <div id="sales-chart3"></div>
                            <h4 id="sales-chart03"></h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>{{date('M Y', strtotime('-2 Month'))}}</h4>
                            <div id="sales-chart2"></div>
                            <h4 id="sales-chart02"></h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>{{date('M Y', strtotime('-1 Month'))}}</h4>
                            <div id="sales-chart1"></div>
                            <h4 id="sales-chart01"></h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>{{date('M Y')}}</h4>
                            <div id="sales-chart0"></div>
                            <h4 id="sales-chart00"></h4>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
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
//            $.ajax({
//                type: 'GET',
//                dataType: 'json',
//                contentType: 'application/json',
//                url: 'statistics/salesBar',
//                data: '{}',
//                success: function (response) {
//                    if(response.length == 0){
//                        response.push({'y':'No Data'})
//                    }
//                    Morris.Bar({
//                        element: 'morris-bar-chart',
//                        data: response,
//                        resize: true,
//                        stacked: true,
//                        xkey: 'y',
//                        ykeys: ['a', 'b', 'c', 'd'],
//                        labels: ['Pending', 'Ordered','Hold', 'Delivered'],
//                        barColors: ['#F0AD4E', '#5BC0DE', '#5CB85C', '#337AB7']
//                    });
//                },
//                error: function (e) {
//                    console.log(e);
//                }
//            });

            $.ajax({
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json',
                url: 'statistics/salesChart',
                data: '{}',
                success: function (response) {
                    Morris.Donut({
                        element: 'morris-donut-chart0',
                        data: response[0],
                        resize: true
//                        formatter: function (y, data) { return '$' + y }
                    });
                    Morris.Donut({
                        element: 'morris-donut-chart1',
                        data: response[1],
                        resize: true
                    });
                    Morris.Donut({
                        element: 'morris-donut-chart2',
                        data: response[2],
                        resize: true
                    });
                    Morris.Donut({
                        element: 'morris-donut-chart3',
                        data: response[3],
                        resize: true
                    });
                    $('#morris-donut-chart00').append('Sum: $').append(response[0].reduce((p,e)=>p+e.value,0));
                    $('#morris-donut-chart01').append('Sum: $').append(response[1].reduce((p,e)=>p+e.value,0));
                    $('#morris-donut-chart02').append('Sum: $').append(response[2].reduce((p,e)=>p+e.value,0));
                    $('#morris-donut-chart03').append('Sum: $').append(response[3].reduce((p,e)=>p+e.value,0));

                },
                error: function (e) {
                    console.log(e);
                }
            });

//            $.ajax({
//                type: 'GET',
//                dataType: 'json',
//                contentType: 'application/json',
//                url: 'statistics/salesLine',
//                data: '{}',
//                success: function (response) {
//                    Morris.Line({
//                        element: 'morris-line',
//                        data: response,
//                        resize: true,
//                        xkey: 'y',
//                        ykeys: ['a', 'b'],
//                        labels: ['Sub Total', 'Deposit']
//                    });
//                },
//
//                error: function (e) {
//                    console.log(e);
//                }
//            });

            $.ajax({
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json',
                url: 'statistics/personalBar',
                data: '{}',
                success: function (response) {
                    if(response.length == 0){
                        response.push({'y':'No Data'})
                    }
                    Morris.Bar({
                        element: 'personal-morris-bar-chart',
                        data: response.data,
                        resize: true,
//                    stacked: true,
                        xkey: 'y',
                        ykeys: ['a', 'b', 'c'],
                        labels: [response.date[0],response.date[1],response.date[2]]
                    });
                },
                error: function (e) {
                    console.log(e);
                }
            });

            $.ajax({
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json',
                url: 'statistics/salesArea',
                data: '{}',
                success: function (response) {
                    Morris.Area({
                        element: 'morris-area',
                        data: response.area,
                        resize: true,
                        xkey: 'y',
                        ykeys: ['a', 'b'],
                        labels: ['Sold', 'Paid'],
                        behaveLikeLine: true
                    });

                    Morris.Donut({
                        element: 'morris-donut-chart4',
                        data: response.payment,
                        resize: true
                    });
                },
                error: function (e) {
                    console.log(e);
                }
            });

            var runonce = false;
            $('.nav-tabs a[href="#menu2"]').on('shown.bs.tab', function(event){
//                var x = $(event.target).text();         // active tab
//                var y = $(event.relatedTarget).text();  // previous tab
                if (runonce)
                    return;
                else
                    runonce = true;

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    contentType: 'application/json',
                    url: 'kitchen/statistics/salesChart',
                    data: '{}',
                    success: function (response) {
                        Morris.Donut({
                            element: 'sales-chart0',
                            data: response[0],
                            resize: true
//                        formatter: function (y, data) { return '$' + y }
                        });
                        Morris.Donut({
                            element: 'sales-chart1',
                            data: response[1],
                            resize: true
                        });
                        Morris.Donut({
                            element: 'sales-chart2',
                            data: response[2],
                            resize: true
                        });
                        Morris.Donut({
                            element: 'sales-chart3',
                            data: response[3],
                            resize: true
                        });
                        $('#sales-chart00').append('Sum: $').append(response[0].reduce((p,e)=>p+e.value,0));
                        $('#sales-chart01').append('Sum: $').append(response[1].reduce((p,e)=>p+e.value,0));
                        $('#sales-chart02').append('Sum: $').append(response[2].reduce((p,e)=>p+e.value,0));
                        $('#sales-chart03').append('Sum: $').append(response[3].reduce((p,e)=>p+e.value,0));

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
        });

    </script>
@endsection
