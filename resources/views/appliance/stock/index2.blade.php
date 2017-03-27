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
            <h1 class="page-header">可用库存 {{array_sum($stocks->pluck('total')->all())}} in total</h1>
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
                    <a href="{{ url('appliance/stock/exportAvailable') }}" target="_blank" class="btn btn-primary ">exportAvailable</a>
                    @can('root')
                        <a href="{{ url('appliance/stock/exportCheckingList') }}" target="_blank" class="btn btn-primary ">CheckingList</a>
                    @endif
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                Quantity
                            </th>
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
                                RRP
                            </th>
                            <th>
                                Promotion price
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $stock->total }}</td>
                                <td>{{ $stock->appliance->model }}</td>
                                <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                <td>{{ $stock->appliance->rrp }}</td>
                                <td>{{ $stock->appliance->promotion }}</td>
                                <td><a href="{{ url('appliance/stock/'.$stock->aid.'/detail') }}" class="btn btn-success">查看</a></td>
                            </tr>
                        @endforeach
                        @foreach ($appliances as $appliance)
                            <tr>
                                <td>0</td>
                                <td>{{ $appliance->model }}</td>
                                <td>{{ $appliance->belongsToBrand->name }}</td>
                                <td>{{ $appliance->belongsToCategory->name }}</td>
                                <td>{{ $appliance->rrp }}</td>
                                <td>{{ $appliance->promotion }}</td>
                                <td></td>
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
                order: [2, 'asc']
            });
        });
    </script>
@endsection