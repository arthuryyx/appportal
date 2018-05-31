@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Display List</h1>
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
            @can('root')
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-5">
                        {!! Form::open(['url' => 'appliance/stock/display','method'=>'POST']) !!}
                        <strong>from stock</strong>
                        <select class="sid form-control" name="sid" required="required"></select>
                        {{ Form::select('shelf', [171 =>'171', '北岸' =>'北岸', '汉密尔顿' =>'汉密尔顿'], null, ['class' => 'form-control', 'placeholder'=>'Location', 'required' => 'required']) }}
                        {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            @endcan
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
                                Shelf
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $stock->appliance->model }}</td>
                                <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                <td>{{ $stock->shelf }}</td>
                                <td>
                                	<a href="{{ url('appliance/stock/'.$stock->id.'/edit') }}" class="btn btn-success">编辑</a>
                                	@can('root')
                               		    <!-- Button trigger modal -->
	                                    <button class="btn btn-danger" data-toggle="modal" data-target={{"#myModal".$stock->id}}>
	                                        重新入库
	                                    </button>
	                                    <!-- Modal -->
	                                    <div class="modal fade" id={{"myModal".$stock->id}} tabindex="-1" role="dialog">
	                                        <div class="modal-dialog">
	                                            <div class="modal-content">
	                                                <div class="modal-header">
	                                                    <button type="button" class="close" data-dismiss="modal" >&times;</button>
	                                                </div>
	                                                <div class="modal-body">
	                                                    Model: {{ $stock->appliance->model }}
	                                                    <br/>
	                                                    Location: {{ $stock->shelf }}
	                                                </div>
	                                                <div class="modal-footer">
	                                                    <form action="{{ url('appliance/stock/reentry') }}" method="POST" style="display: inline;">
	                                                        {{ csrf_field() }}
	                                                        <input type="hidden" name="sid" value="{{$stock->id}}">
	                                                        <button type="submit" class="btn btn-danger">确认</button>
	                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
	                                                    </form>
	                                                </div>
	                                            </div>
	                                            <!-- /.modal-content -->
	                                        </div>
	                                        <!-- /.modal-dialog -->
	                                    </div>
	                                    <!-- /.modal -->
                                	@endcan
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
    <script src="{{ asset('vendor/select2/select2.min.js')}}"></script>

    <script type="text/javascript">
        $('.sid').select2({
            placeholder: 'Select an item',
            ajax: {
                url: '/select2-autocomplete-ajax/available',
                dataType: 'json',
                delay: 200,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.model + ' 【' + item.shelf + '】',
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

    </script>
    <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                responsive: true,
                paging: false
            });
        });
    </script>
@endsection