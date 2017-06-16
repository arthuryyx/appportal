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
            <h1 class="page-header">Material Item List</h1>
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
                    <a href="{{ url('material/item/create/type') }}" class="btn btn-primary ">New</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                Model
                            </th>
                            <th>
                                Attributes
                            </th>
                            <th>
                                Supplier
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->values->implode('value', ', ') }}</td>
                                <td>{{ $item->getSupplier->name }}</td>
                                {{--<td><a href="{{ url('material/attribute/'.$attribute->id) }}" class="btn btn-info">Detail</a></td>--}}
                                {{--<td><a href="{{ url('material/attribute/'.$attribute->id.'/edit') }}" class="btn btn-success">Edit</a></td>--}}
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
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
//                columnDefs: [
//                    { "width": "10%", "targets": 3 }
//                    { type: 'date-eu', targets: 5 }
//                ],
                responsive: true,
                pageLength: 100,
                order: [0]
            });
        });
    </script>
@endsection