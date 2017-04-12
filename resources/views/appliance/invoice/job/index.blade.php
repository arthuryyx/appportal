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
            <h1 class="page-header">Appliance Job Invoices List</h1>
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
                <div class="panel-heading">
                    <a href="{{ url('appliance/invoice/job/create') }}" class="btn btn-primary ">New</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                receipt_id
                            </th>
                            <th>
                                job_id
                            </th>
                            <th>
                                customer_name
                            </th>
                            <th>
                                address
                            </th>
                            <th>
                                created_by
                            </th>
                            <th>
                                created_at
                            </th>
                            <th>
                                state
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->receipt_id }}</td>
                                <td>{{ $invoice->job_id }}</td>
                                <td>{{ $invoice->customer_name }}</td>
                                <td>{{ $invoice->address }}</td>
                                <td>{{ $invoice->getCreated_by->name }}</td>
                                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @if($invoice->state == 0)
                                        <label class="label label-danger">Unpaid</label>
                                    @elseif($invoice->state == 1)
                                        <label class="label label-success">&nbsp;&nbsp;Paid&nbsp;&nbsp;</label>
                                    @else
                                        <label class="label label-primary">Exception</label>
                                    @endif
                                </td>
                                <td><a href="{{ url('appliance/invoice/job/'.$invoice->id) }}" class="btn btn-info">详情</a></td>
                                <td><a href="{{ url('appliance/invoice/job/'.$invoice->id.'/edit') }}" class="btn btn-success">修改</a></td>
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
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                responsive: true,
                pageLength: 100,
                order: [5, 'asc']
            });
        });
    </script>
@endsection