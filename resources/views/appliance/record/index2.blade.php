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
            <h1 class="page-header">Arrival History</h1>
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
                            <th>
                                Model
                            </th>
                            <th>
                                Brand
                            </th>
                            <th>
                                Order
                            </th>
                            <th>
                                By
                            </th>
                            <th>
                                Date & Time
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($records as $record)
                            @if($record->stock)
                                <tr>
                                    <td>{{ $record->stock->appliance->model }}</td>
                                    <td>{{ $record->stock->appliance->belongsToBrand->name }}</td>
                                    <td>@if($record->stock->getOrder->invoice_id){{ $record->stock->getOrder->getInvoice->receipt_id }}@endif{{ $record->stock->getOrder->ref }}</td>
                                    <td>{{ $record->getCreated_by->name }}</td>
                                    <td>{{ $record->created_at }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>$record->id</td>
                                    <td>{{ $record->getCreated_by->name }}</td>
                                    <td>{{ $record->created_at }}</td>
                                </tr>    
                            @endif
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
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                responsive: true,
                pageLength: 25,
                order: [4]
            });
        });
    </script>
@endsection