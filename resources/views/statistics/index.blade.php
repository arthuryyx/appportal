@extends('layouts.app')

@section('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-2">
            <h1 class="page-header">{{$date}}</h1>
        </div>
        {!! Form::open(['url' => 'statistics/sales','method'=>'POST']) !!}
            <div class="col-lg-2">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker3'>
                        <input type='text' name="date" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
            </div>
        {!! Form::close() !!}
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! implode('<br>', $errors->all()) !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                brand
                            </th>
                            <th>
                                model
                            </th>
                            <th>
                                total
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($data as $product)
                            <tr>
                                <td>{{ $product->appliance->belongsToBrand->name }}</td>
                                <td>{{ $product->appliance->model }}</td>
                                <td>{{ $product->total }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

@endsection

@section('js')
    <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    {{--<script src="{{ asset('vendor/datatables-plugins/date-eu.js')}}"></script>--}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
//                columnDefs: [
//                    { "width": "10%", "targets": 2 },
//                    { "width": "10%", "targets": 3 }
//                    { type: 'date-eu', targets: 5 }
//                ],
                responsive: true,
                pageLength: 100,
                order: [1]
            });
        });
        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'mm-yyyy',
                autoclose: true,
                startView: 3,
                minView: 3,
                forceParse: false
            });
        });
    </script>
@endsection