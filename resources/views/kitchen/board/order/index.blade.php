@extends('layouts.app')

@section('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Order List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

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

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                {{--@if(Route::currentRouteName() == 'order.index')--}}
                <div class="panel-heading">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModal"}}>New</button>
                    <!-- Modal -->
                    <div class="modal fade" id={{"myModal"}} tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {!! Form::open(['url' => 'kitchen/board/order','method'=>'POST']) !!}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                    <h3>新建</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <strong>Ref:</strong>
                                        {!! Form::text('ref', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{Form::submit('Submit', ['class' => 'btn btn-success pull-right'])}}
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                {{--@endif--}}
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>ref</th>
                            <th>created_by</th>
                            <th>created_at</th>
                            <th>view</th>
                        </tr>
                        </thead>
                        {{--<tbody>--}}
                        {{--@foreach ($orders as $order)--}}
                            {{--<tr>--}}
                                {{--<td>--}}
                                    {{--@if($order->invoice_id)--}}
                                        {{--{{ $order->getInvoice->receipt_id }}.{{ $order->ref }}--}}
                                    {{--@else--}}
                                        {{--{{ $order->ref }}--}}
                                    {{--@endif--}}
                                {{--</td>--}}
                                {{--<td>{{ $order->comment }}</td>--}}
                                {{--<td>{{ $order->getCreated_by->name }}</td>--}}
                                {{--<td>{{ $order->created_at->format('d-m-Y') }}</td>--}}
                                {{--<td><a href="{{ url('appliance/order/'.$order->id) }}" class="btn btn-info">详情</a></td>--}}
                                {{--<td><a href="{{ url('appliance/order/'.$order->id.'/edit') }}" class="btn btn-success">修改</a></td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
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
    <script src="{{ asset('vendor/datatables-plugins/date-eu.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
//                serverMethod: 'post',
                ajax: {
                    'url':'order/ajax-index'
                },
                columns: [
                    { data: 'ref'},
                    { data: 'created_by', name: 'getCreated_by.name'},
                    { data: 'created_at' },
                    { data: 'view', orderable: false, searchable: false }
                ],
                columnDefs: [
//                    { width: "15%", "targets": 8 },
                    { type: 'date-eu', targets: 2 }
                ],
                responsive: true,
                order: [2]
            });
        });
    </script>
@endsection