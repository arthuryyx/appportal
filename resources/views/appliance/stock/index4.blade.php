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
            <h1 class="page-header">Ready To Go</h1>
            <p>
                <li>集装箱 1            C1</li>
                <li>集装箱 2           C2</li>
                <li>集装箱 3           C3</li>
                <li>石材大仓库       S1</li>
                <li>石材小仓库       S2</li>
                <li>石材展厅           S3</li>
                <li>石材外围           S4</li>
                <li>171 展厅            171</li>
            </p>
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
                            <th>
                                Model
                            </th>
                            <th>
                                Brand
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Receipt No.
                            </th>
                            <th>
                                Shelf
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                {{--<td>{{ $stock->total }}</td>--}}
                                <td>{{ $stock->appliance->model }}</td>
                                <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                <td>{{ $stock->getAssignTo->receipt_id }}</td>
                                <td>{{ $stock->shelf }}</td>
                                <td><a href="{{ url('appliance/stock/'.$stock->id.'/edit') }}" class="btn btn-success">编辑</a></td>
                                <td><a href="{{ url('appliance/invoice/job/'.$stock->getAssignTo->id) }}" class="btn btn-success">查看</a></td>
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
                paging: false,
                order: [3, 'asc']
            });
        });
    </script>
@endsection