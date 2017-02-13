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
            <h1 class="page-header">Appliance Management</h1>
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
                    <a href="{{ url('admin/appliance/create') }}" class="btn btn-primary ">Add</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                Name
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
                                Best price
                            </th>
                            <th>
                                RRP
                            </th>
                            <th>
                                Promotion price
                            </th>
                            <th>
                                Cut-out
                            </th>
                            <th>
                                Description
                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($appliances as $appliance)
                            <tr>
                                <td>{{ $appliance->name }}</td>
                                <td>{{ $appliance->model }}</td>
                                <td>{{ $appliance->belongsToBrand->name }}</td>
                                <td>{{ $appliance->belongsToCategory->name }}</td>
                                <td>{{ $appliance->best }}</td>
                                <td>{{ $appliance->rrp }}</td>
                                <td>{{ $appliance->promotion }}</td>
                                <td>{{ $appliance->cutout }}</td>
                                <td>{{ $appliance->description }}</td>
                                <td><a href="{{ url('admin/appliance/'.$appliance->id.'/edit') }}" class="btn btn-success">编辑</a></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger" data-toggle="modal" data-target={{"#myModal".$appliance->id}}>
                                        删除
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id={{"myModal".$appliance->id}} tabindex="-1" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    {{$appliance->model}}
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ url('admin/appliance/'.$appliance->id) }}" method="POST" style="display: inline;">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger">删除</button>
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </td>
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
                responsive: true
            });
        });
    </script>
@endsection