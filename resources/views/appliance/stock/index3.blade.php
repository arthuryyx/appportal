@extends('layouts.app')

@section('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Delivered</h1>
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
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            {{--<th>--}}
                                {{--Quantity--}}
                            {{--</th>--}}
                            <th>model</th>
                            <th>brand</th>
                            <th>category</th>
                            <th>receipt</th>
                            <th>date</th>
                            <th>action</th>
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
                    'url':'/appliance/stock/ajaxIndex/3'
                },
                columns: [
                    { data: 'appliance.model', orderable: false },
                    { data: 'brand', name: 'appliance.belongsToBrand.name', orderable: false },
                    { data: 'category', name: 'appliance.belongsToCategory.name', orderable: false },
                    { data: 'receipt', name: 'getDeliveryHistory.getInvoice.receipt_id', orderable: false },
                    { data: 'date', name: 'getDeliveryHistory.created_at'},
                    { data: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { type: 'date-eu', targets: 4 }
                ],
                responsive: true,
//                pageLength: 50,
                order: [4]
            });
        });
    </script>
@endsection