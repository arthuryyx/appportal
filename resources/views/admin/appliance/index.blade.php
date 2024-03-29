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
                    @can('appliance_add')<a href="{{ url('admin/appliance/create') }}" class="btn btn-primary ">Add</a>@endcan
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>Model</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>RRP</th>
                            <th>RSP</th>
                            <th>Lv2</th>
                            <th>Lv3</th>
                            <th>Cost Price</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        {{--<tbody>--}}
                        {{--@foreach ($appliances as $appliance)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $appliance->model }}</td>--}}
                                {{--<td>{{ $appliance->belongsToBrand->name }}</td>--}}
                                {{--<td>{{ $appliance->belongsToCategory->name }}</td>--}}
                                {{--<td>{{ $appliance->rrp }}</td>--}}
                                {{--<td>{{ $appliance->lv1 }}</td>--}}
                                {{--<td>{{ $appliance->lv2 }}</td>--}}
                                {{--<td>{{ $appliance->lv3 }}</td>--}}
                                {{--<td>{{ $appliance->lv4 }}</td>--}}
                                {{--<td>--}}
                                    {{--@if($appliance->state)--}}
                                        {{--<label class="label label-danger">Discontinued</label>--}}
                                    {{--@else--}}
                                        {{--<label class="label label-success">In Use</label>--}}
                                    {{--@endif--}}
                                {{--</td>--}}
                                {{--<td>{{ $appliance->description }}</td>--}}
                                {{--<td></td>--}}
                                {{--<td>@can('appliance_delete')--}}
                                    {{--<!-- Button trigger modal -->--}}
                                    {{--<button class="btn btn-danger" data-toggle="modal" data-target={{"#myModal".$appliance->id}}>--}}
                                        {{--删除--}}
                                    {{--</button>--}}
                                    {{--<!-- Modal -->--}}
                                    {{--<div class="modal fade" id={{"myModal".$appliance->id}} tabindex="-1" role="dialog">--}}
                                        {{--<div class="modal-dialog">--}}
                                            {{--<div class="modal-content">--}}
                                                {{--<div class="modal-header">--}}
                                                    {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-body">--}}
                                                    {{--{{$appliance->model}}--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-footer">--}}
                                                    {{--<form action="{{ url('admin/appliance/'.$appliance->id) }}" method="POST" style="display: inline;">--}}
                                                        {{--{{ method_field('DELETE') }}--}}
                                                        {{--{{ csrf_field() }}--}}
                                                        {{--<button type="submit" class="btn btn-danger">删除</button>--}}
                                                        {{--<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>--}}
                                                    {{--</form>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<!-- /.modal-content -->--}}
                                        {{--</div>--}}
                                        {{--<!-- /.modal-dialog -->--}}
                                    {{--</div>--}}
                                    {{--<!-- /.modal -->@endcan--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
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
                processing: true,
                serverSide: true,
//                serverMethod: 'post',
                ajax: {
                    'url':'appliance/ajax-index'
                },
                columns: [
                    { data: 'model'},
                    { data: 'brand', name: 'belongsToBrand.name' },
                    { data: 'category', name: 'belongsToCategory.name' },
                    { data: 'rrp'},
                    { data: 'lv1'},
                    { data: 'lv2'},
                    { data: 'lv3'},
                    { data: 'lv4'},
                    { data: 'state', name: 'state', searchable: false },
                    { data: 'description', orderable: false, searchable: false },
                    { data: 'edit', orderable: false, searchable: false }
                ],
                autoWidth: false,
                responsive: true
            });
        });
    </script>
@endsection