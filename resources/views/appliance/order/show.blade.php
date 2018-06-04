@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Order Info</h1>
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
                    @if($order->getState->count())
                        @can('appliance_order')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target={{"#myModal"}}>Order</button>
                            <!-- Modal -->
                            <div class="modal fade" id={{"myModal"}} tabindex="-1" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                        </div>
                                        <div class="modal-body">
                                        <strong>confirm order</strong>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('appliance/order/confirm') }}" method="POST" style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{$order->id}}">
                                                <button type="submit" class="btn btn-danger">confirm</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        @endcan
                    @elseif($order->state == 1)
                        <a href="{{ url('appliance/order/'.$order->id.'/html') }}" class="btn btn-primary" target="_blank">Print</a>
                    @endif
                    <table width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Order Ref</th>
                                <th>Data</th>
                                <th>Created By</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if($order->invoice_id)
                                        {{ $order->getInvoice->receipt_id }}.{{ $order->ref }}
                                    @else
                                        {{ $order->ref }}
                                    @endif
                                </td>
                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                                <td>{{$order->getCreated_by->name}}</td>
                                <td>{{$order->comment}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($order->state == 0 || Gate::check('root'))
                    @can('appliance_order')
                        <hr>
                        <div class="col-lg-4">
                            {!! Form::open(['url' => 'appliance/stock','method'=>'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>place new order</strong>
                                    <select class="aid form-control" name="aid" required="required"></select>
                                    <strong>quantity</strong>
                                    {{ Form::number('qty', 1, array('class' => 'form-control')) }}
                                    {{ Form::hidden('order_id', $order->id) }}
                                    {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    @endcan
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <form id="frm-example" name="frm_example" action="" method="post">
                    {{ csrf_field() }}
                    @if($order->state == 1)
                        <div class="panel-heading">
                            @can('appliance_arrival')
                                <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/arrive')}}'">arrival</button>
                            @endcan
                            @can('root')
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
                            @endcan
                        </div>
                    @endif
                    <div class="panel panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
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
                                    Job
                                </th>
                                <th>
                                    State
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->getStocks as $stock)
                                <tr>
                                    <td>{{ $stock->id }}</td>
                                    <td>{{ $stock->appliance->model }}</td>
                                    <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                    <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                    <td>
                                    	@if($stock->assign_to != null)
                                            <a href="{{ url('appliance/invoice/job/'.$stock->assign_to) }}" class="btn btn-success">{{ $stock->getAssignTo->receipt_id }}</a>
                                        @endif
                                    
                                    </td>
                                    <td>
                                        {{ $stock->id }}
                                        @if($stock->state == 0)
                                            <label class="label label-warning">Pending</label>
                                        @elseif($stock->state == 1)
                                            <label class="label label-info">Order placed</label>
                                        @elseif($stock->state == 2)
                                            <label class="label label-success">In Stock</label>
                                        @elseif($stock->state == 3)
                                            <label class="label label-primary">Delivered</label>
                                        @elseif($stock->state == 5)
                                            <label class="label label-primary">Display</label>
                                        @else
                                            <label class="label label-danger">Exception</label>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('vendor/select2/select2.min.js')}}"></script>

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
                searching: false,
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
                order: [[1, 'asc']]
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

    <script type="text/javascript">
        $('.aid').select2({
            placeholder: 'Select an model',
            ajax: {
                url: '/select2-autocomplete-ajax/applianceModel',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.model,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

    </script>
@endsection
