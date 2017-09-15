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
            <h1 class="page-header">Appliance Order List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! implode('<br>', $errors->all()) !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                @if(Route::currentRouteName() == 'order.index')
                    <div class="panel-heading">
                        <a href="{{ url('appliance/order/create') }}" class="btn btn-primary ">New</a>
                    </div>
                @endif
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                ref
                            </th>
                            <th>
                                comment
                            </th>
                            <th>
                                created_by
                            </th>
                            <th>
                                created_at
                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    @if($order->invoice_id)
                                        {{ $order->getInvoice->receipt_id }}.{{ $order->ref }}
                                    @else
                                        {{ $order->ref }}
                                    @endif
                                </td>
                                <td>{{ $order->comment }}</td>
                                <td>{{ $order->getCreated_by->name }}</td>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td><a href="{{ url('appliance/order/'.$order->id) }}" class="btn btn-info">详情</a></td>
                                <td><a href="{{ url('appliance/order/'.$order->id.'/edit') }}" class="btn btn-success">修改</a></td>
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
    <script src="{{ asset('vendor/datatables-plugins/date-eu.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                columnDefs: [
                    { type: 'date-eu', targets: 3 }
                ],
                responsive: true,
                pageLength: 100,
                order: [3]
            });
        });
    </script>
@endsection