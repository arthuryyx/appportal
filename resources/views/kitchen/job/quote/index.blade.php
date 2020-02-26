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
            <h1 class="page-header">Quote</h1>
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
                    <a href="{{ url('kitchen/job/quote/create') }}" class="btn btn-primary" target="_blank">New</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                quote_no
                            </th>
                            <th>
                                customer_name
                            </th>
                            <th>
                                phone
                            </th>
                            <th>
                                email
                            </th>
                            <th>
                                address
                            </th>
                            <th>
                                total
                            </th>
                            <th>
                                created_by
                            </th>
                            <th>
                                created_at
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($quotes as $quote)
                            <tr>
                                <td>{{ $quote->quote_no }}</td>
                                <td>{{ $quote->customer }}</td>
                                <td>{{ $quote->phone }}</td>
                                <td>{{ $quote->email }}</td>
                                <td>{{ $quote->address }}</td>
                                <td>{{ $quote->hasManyItems->sum('price') }}</td>
                                <td>{{ $quote->getCreated_by->name }}</td>
                                <td>{{ $quote->created_at->format('d-m-Y') }}</td>
                                <td><a href="{{ url('kitchen/job/quote/'.$quote->id) }}" class="btn btn-success" target="_blank">详情</a></td>
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
                autoWidth: false,
                columnDefs: [
                    { type: 'date-eu', targets: 7 },
                ],
                responsive: true,
                pageLength: 25,
                order: [7]
            });
        });
    </script>
@endsection