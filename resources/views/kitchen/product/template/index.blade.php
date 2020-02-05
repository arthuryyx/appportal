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
            <h1 class="page-header">Kitchen Product Template</h1>
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
                <!-- /.panel-heading -->
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
                                Category
                            </th>
                            <th>
                                Size
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Status
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($table as $template)
                            <tr>
                                <td>{{ $template->model }}</td>
                                <td>{{ $template->brand }}</td>
                                <td>{{ $template->category }}</td>
                                <td>{{ $template->size }}</td>
                                <td>{{ $template->lv1 }}</td>
                                <td>{{ $template->description }}</td>
                                <td>
                                    @if($template->status)
                                        <label class="label label-success">In Use</label>
                                    @else
                                        <label class="label label-danger">Discontinued</label>
                                    @endif
                                </td>
                                <td><a href="{{ url('kitchen/product/template/'.$template->id.'/edit') }}" class="btn btn-success" target="_blank">编辑</a></td>
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