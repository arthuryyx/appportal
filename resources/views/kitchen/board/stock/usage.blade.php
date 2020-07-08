@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">出库</h1>
        </div>
        {!! Form::open(['url' => 'kitchen/board/usage','method'=>'POST']) !!}
        <div class="col-lg-4">
            <select id="selectBoard" class="form-control" name="stock_id" required="required"></select>
        </div>
        <div class="col-lg-2">
            {{ Form::text('job_no', '', array('class' => 'form-control', 'placeholder' => 'Job No.')) }}
        </div>
        <div class="col-lg-2">
            {{ Form::number('qty', '', array('class' => 'form-control', 'placeholder' => 'Qty', 'required' => 'required')) }}
        </div>
        <div class="col-lg-1">
            {{Form::submit('Submit', ['class' => 'btn btn-success pull-right'])}}
        </div>
        {!! Form::close() !!}
    </div>
    <br>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @elseif ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ $message }}
                        </div>
                    @endif
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Board</th>
                            <th>Job</th>
                            <th>Qty</th>
                            <th>By</th>
                            <th>Date</th>
                        </tr>
                        </thead>
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
    <script src="{{ asset('vendor/select2/select2.min.js')}}"></script>

    <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/date-eu.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
//                serverMethod: 'post',
                ajax: {
                    'url':'ajax-usage'
                },
                columns: [
                    { data: 'brand', name: 'getStock.brand'},
                    { data: 'title', name: 'getStock.title'},
                    { data: 'job_no', name: 'getItem.job_no'},
                    { data: 'qty', name: 'value'},
                    { data: 'created_by', name: 'getCreated_by.name'},
                    { data: 'created_at' }
                ],
                responsive: true,
            });
        });
    </script>

        <script type="text/javascript">
            $('#selectBoard').select2({
                placeholder: 'Board',
                ajax: {
                    url: '/kitchen/board/name-select2',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.brand + ' | ' + item.title + ' | ' + item.size,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

        </script>
@endsection