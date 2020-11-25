@extends('layouts.app')

@section('css')
    <!-- DataTables CSS -->
    {{--<link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">--}}

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Pending Order</h1>
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
                <form id="frm-example" name="frm_example" action="" method="post">
                    {{ csrf_field() }}
                    @can('appliance_merge')
                    <div class="panel-heading">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModalmerge"}}>Merge</button>
                        <!-- Modal -->
                        <div class="modal fade" id={{"myModalmerge"}} tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                        <h3>Bulk</h3>
                                    </div>
                                    <div class="modal-body">
                                        <strong>Order Ref.</strong>
                                        <input type="text" name="ref" class="form-control">
                                        <strong>Comment</strong>
                                        <textarea name="comment" class="form-control"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/order/merge')}}'">merge</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModalappend"}}>Append</button>
                        <!-- Modal -->
                        <div class="modal fade" id={{"myModalappend"}}  role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <strong>Appliance</strong>
                                        <select class="ref form-control" name="ref"></select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/order/append')}}'">Confirm</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target={{"#myModaldelete"}}>Delete</button>
                        <!-- Modal -->
                        <div class="modal fade" id={{"myModaldelete"}} tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                        
                                        <button type="submit" class="btn btn-danger" onclick="document.frm_example.action='{{ url('appliance/stock/delete')}}'">Confirm</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>
                    @endcan
                    
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                {{--<th>--}}
                                    {{--Quantity--}}
                                {{--</th>--}}
                                <th></th>
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
                                <th>Job No.</th>
                                {{--@can('root')--}}
                                {{--<th></th>--}}
                                {{--@endcan--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($stocks as $stock)
                                <tr>
                                    {{--<td>{{ $stock->total }}</td>--}}
                                    <td>{{ $stock->id }}</td>
                                    <td>{{ $stock->appliance->model }}</td>
                                    <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                    <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                    
                                    @if($stock->order_id == null)
                                    	<td></td>
                                    @else
                                    	<td>
                                    		<a href="{{ url('appliance/order/'.$stock->order_id) }}" class="btn btn-success">查看{{ $stock->getOrder->ref}}</a>
                                    	</td>
                                    @endif
                                    
                                    @if($stock->assign_to == null)
                                    	<td></td>
                                    @else
                                    	<td>
                                    		<a href="{{ url('appliance/invoice/job/'.$stock->getAssignTo->id) }}" class="btn btn-success">查看{{ $stock->getAssignTo->receipt_id }}</a>
                                    	</td>
                                    @endif
                                    
                                    {{--@can('root')--}}
                                    {{--<td>--}}
                                        {{--<!-- Button trigger modal -->--}}
                                        {{--<button class="btn btn-danger" data-toggle="modal" data-target={{"#myModal".$stock->id}}>--}}
                                            {{--删除--}}
                                        {{--</button>--}}
                                        {{--<!-- Modal -->--}}
                                        {{--<div class="modal fade" id={{"myModal".$stock->id}} tabindex="-1" role="dialog">--}}
                                            {{--<div class="modal-dialog">--}}
                                                {{--<div class="modal-content">--}}
                                                    {{--<div class="modal-header">--}}
                                                        {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="modal-body">--}}
                                                        {{--{{ $stock->appliance->model }}--}}
                                                    {{--</div>--}}
                                                    {{--<div class="modal-footer">--}}
                                                        {{--<form action="{{ url('appliance/stock/'.$stock->id) }}" method="POST" style="display: inline;">--}}
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
                                        {{--<!-- /.modal -->--}}
                                    {{--</td>--}}
                                    {{--@endcan--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </form>
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
        $('.ref').select2({
            placeholder: 'Select a Order',
            ajax: {
                url: '/select2-autocomplete-ajax/existOrder',
                dataType: 'json',
                delay: 200,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.ref,
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
    <script src="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.min.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            var table = $('#dataTables').DataTable({
                responsive: true,
                paging: false,
                columnDefs: [
                    {
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true,
                            'value': 1
                        }
                    }
                ],
                select: {
                    'style': 'multi'
                },
                order: [[3, 'asc']]
            });

            // Handle form submission event
            $('#frm-example').on('submit', function(e){
                var form = this;
                var rows_selected = table.column(0).checkboxes.selected();
                // Iterate over all selected checkboxes
                $.each(rows_selected, function(index, sid){
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'id[]')
                            .val(sid)
                    );
                });
            });
        });
    </script>
@endsection