@extends('layouts.app')

@section('css')
    <!-- Morris Charts CSS -->
    <link href="{{ asset('vendor/morrisjs/morris.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">

@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                {!! Form::open(['url' => 'statistics/payment','method'=>'POST']) !!}
                <div class='col-md-2'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker6'>
                            <input type='text' name="StartDate" class="form-control" required="required" value="{{$start}}"/>
                            <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='text' name="EndDate" class="form-control" required="required" value="{{$end}}"/>
                            <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                    {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <form id="frm_example" name="frm_example" action="" method="post">
                    {{ csrf_field() }}
                    <input name="start" value="{{$start}}" style="visibility: hidden">
                    <input name="end" value="{{$end}}" style="visibility: hidden">
                    @foreach($data as $dt)
                        <div class="col-lg-4 ">
                            <h4 id="name-{{$dt}}"></h4>
                            @if(Auth::user()->id == $dt || Gate::check('appliance_view_all_jobs'))
                                <button type="submit" class="btn btn-success" onclick="document.frm_example.action='{{ url('/appliance/unpaid/index/'.$dt)}}'">more</button>
                            @else
                                <button type="submit" class="btn btn-success" disabled="disabled">more</button>
                            @endif
                            <div id="morris-donut-chart-3-{{$dt}}"></div>
                            <text class="hidden">{{$dt}}</text>
                        </div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('vendor/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('vendor/morrisjs/morris.min.js')}}"></script>
    <script src="{{ asset('js/data/morris-data.js')}}"></script>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var startDate = $('input[name ="StartDate"]').val();
            var endDate = $('input[name ="EndDate"]').val();
            $('.hidden').each(function(i, obj) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'payment/'+obj.textContent,
                    data: {
                        'startDate': startDate,
                        'endDate':  endDate
                        },
                    success: function (response) {
                        Morris.Donut({
                            element: 'morris-donut-chart-3-'+obj.textContent,
                            data: response['arr'],
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
        $(function () {
            $('#datetimepicker6').datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
//                startView: 3,
                minView: 3,
                forceParse: false
            });
            $('#datetimepicker7').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format: 'yyyy-mm-dd',
                autoclose: true,
//                startView: 3,
                minView: 3,
                forceParse: false
            });
            $('#datetimepicker6').on("changeDate", function (e) {
                $('#datetimepicker7').datetimepicker('setStartDate', e.date);
            });
            $('#datetimepicker7').on("changeDate", function (e) {
                $('#datetimepicker6').datetimepicker('setEndDate', e.date);
            });
        });
    </script>
@endsection