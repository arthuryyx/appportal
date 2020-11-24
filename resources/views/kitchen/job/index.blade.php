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
            <h1 class="page-header">Kitchen Jobs</h1>
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
                <div class="panel-heading">
                    <a href="{{ url('kitchen/job/create') }}" class="btn btn-primary" target="_blank">New</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>Job</th>
                                <th>Ref</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>By</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Payment</th>
                                <th></th>
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
        jQuery.fn.dataTableExt.oSort['number-fate-asc']  = function(s1,s2) {
            s1 = s1.replace('K','');
            s2 = s2.replace('K','');
            return s1-s2;
        };

        jQuery.fn.dataTableExt.oSort['number-fate-desc'] = function(s1,s2) {
            s1 = s1.replace('K','');
            s2 = s2.replace('K','');
            return s2-s1;
        };

    </script>
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
//                serverMethod: 'post',
                ajax: {
                    'url':'job/ajax-index'
                },
                columns: [
                    { data: 'job'},
                    { data: 'ref' },
                    { data: 'customer_name' },
                    { data: 'phone', orderable: false },
                    { data: 'address', orderable: false },
                    { data: 'created_by', name: 'getCreated_by.name' },
                    { data: 'price' },
                    { data: 'created_at' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
//                    { width: "15%", "targets": 8 },
                    { type: 'date-eu', targets: 7 },
                    { type: 'number-fate', targets: 0 }
                ],
                autoWidth: false,
                responsive: true,
                pageLength: 25,
                order: [7]
            });
        });
    </script>
@endsection