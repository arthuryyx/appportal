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
            <h2>Date: {{$date}}</h2>
            <h2>{{$stocks->sum('total')}} Item(s)</h2>
            <h2>
                ${{ $stocks->sum(function ($stock) {
	    		    return $stock->appliance->rrp?($stock->appliance->rrp*$stock->total):0;
		        }) }}
            </h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row --><div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                Amount
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
                                RSP
                            </th>                  
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($stocks->sortBy('appliance.model') as $stock)
                            <tr>
                                <td>{{ $stock->total }}</td>
                                <td>{{ $stock->appliance->model }}</td>
                                <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                <td>{{ $stock->appliance->rrp}}</td>
                                <td>{{ $stock->appliance->lv1 }}</td>
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
                order: [1, 'asc']
            });
        });
    </script>
@endsection