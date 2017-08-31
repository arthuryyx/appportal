@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Invoice Info</h1>
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
                    @if($invoice->state == 0)
                        @can('appliance_confirm_payment')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target={{"#myModalpayment"}}>Payment</button>
                            <!-- Modal -->
                            <div class="modal fade" id={{"myModalpayment"}} tabindex="-1" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>${{array_sum($invoice->hasManyDeposits->pluck('amount')->all())}}</strong>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('appliance/invoice/paid') }}" method="POST" style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{$invoice->id}}">
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
                    @endif
                    <a href="{{ url('appliance/invoice/job/'.$invoice->id.'/html') }}" class="btn btn-primary" target="_blank">Print</a>
                    <a href="{{ url('appliance/invoice/job/'.$invoice->id.'/edit') }}" class="btn btn-success">Edit</a>
                    <table width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Receipt No.</th>
                                <th>Data</th>
                                <th>Job</th>
                                <th>Job No.</th>
                                <th>Final Price</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Comment</th>
                                <th>Deliver Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$invoice->receipt_id}}</td>
                                <td>{{$invoice->created_at->format('d-m-Y')}}</td>
                                <td>{{$invoice->getCreated_by->name}}</td>
                                <td>{{$invoice->job_id}}</td>
                                <td>{{$invoice->price}}</td>
                                <td>{{$invoice->customer_name}}</td>
                                <td>{{$invoice->address}}</td>
                                <td>{{$invoice->comment}}</td>
                                <td>{{$invoice->fee}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="col-lg-2">
                        @if($invoice->state == 0)
                            <img src="{{ asset('img/unpaid.png')}}" height="150" width="150">
                        @elseif($invoice->state == 1)
                            <img src="{{ asset('img/paid.png')}}" height="150" width="150" >
                        @endif
                    </div>
                    {{--<div class="col-lg-3">--}}
                        {{--{!! Form::open(['url' => 'appliance/stock/job/assign','method'=>'POST']) !!}--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-10 col-sm-10 col-md-10">--}}
                                {{--<strong>from stock</strong>--}}
                                {{--<select class="sid form-control" name="sid" required="required"></select>--}}
                                {{--{{ Form::hidden('assign_to', $invoice->id) }}--}}
                                {{--{{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--{!! Form::close() !!}--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-3">--}}
                        {{--{!! Form::open(['url' => 'appliance/stock','method'=>'POST']) !!}--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-10 col-sm-10 col-md-10">--}}
                                {{--<strong>order new</strong>--}}
                                {{--<select class="aid form-control" name="aid" required="required"></select>--}}
                                {{--<strong>quantity</strong>--}}
                                {{--{{ Form::number('qty', 1, array('class' => 'form-control', 'required' => 'required')) }}--}}
                                {{--{{ Form::hidden('job', $invoice->id) }}--}}
                                {{--{{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--{!! Form::close() !!}--}}
                    {{--</div>--}}

                    @if($invoice->state == 0)
                    <div class="col-lg-4">
                        {!! Form::open(['url' => 'appliance/stock/allocation','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-10 col-sm-10 col-md-10">
                                <strong>Appliance</strong>
                                <select class="aid form-control" name="aid" required="required"></select>
                                <strong>Price</strong>
                                {{ Form::number('price', null, array('class' => 'form-control', 'step' => 'any')) }}
                                <strong>Warranty (year)</strong>
                                {{ Form::number('warranty', null, array('class' => 'form-control')) }}
                                {{ Form::hidden('assign_to', $invoice->id) }}
                                {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    @can('appliance_add_deposit')
                    <div class="col-lg-4">
                        {!! Form::open(['url' => 'appliance/deposit','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-10 col-sm-10 col-md-10">
                                <strong>Deposit</strong>
                                {{ Form::number('amount', null, array('class' => 'form-control', 'step' => 'any', 'required' => 'required')) }}
                                {{ Form::hidden('invoice_id', $invoice->id) }}
                                {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @endcan
                    @endif

                    <div class="col-lg-2">
                        <p>
                            <strong>Deposit History: </strong>
                            <a href="{{ url('appliance/deposit/index/'.$invoice->id) }}" class="btn btn-primary">view</a>
                        </p>
                        <hr>
                        <p>
                            <strong>Delivery History: </strong>
                            <a href="{{ url('appliance/delivery/index/'.$invoice->id) }}" class="btn btn-primary">view</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <form id="frm-example" name="frm_example" action="" method="post">
                    {{ csrf_field() }}

                    <div class="panel-heading">
                        @can('appliance_order')
                        <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/order/'.$invoice->id)}}'">order</button>
                        @endcan
                        @can('appliance_switch')
                            <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/switch')}}'">switch</button>
                        @endcan
                        @can('appliance_release')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModalrelease"}}>release</button>
                        <!-- Modal -->
                        <div class="modal fade" id={{"myModalrelease"}} tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        Confirm release appliance from current job!
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/release')}}'">release</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        @endcan
                        @can('appliance_deliver')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModaldeliver"}}>deliver</button>
                        <!-- Modal -->
                        <div class="modal fade" id={{"myModaldeliver"}} tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <strong>Carrier</strong>
                                        <input type="text" name="carrier" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/deliver/'.$invoice->id)}}'">deliver</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        @endcan
                    </div>
                    <div class="panel panel-body">
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
                                    State
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Warranty
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoice->hasManyStocks as $stock)
                                <tr>
                                    {{--<td>{{ $stock->total }}</td>--}}
                                    <td>{{ $stock->id }}</td>
                                    <td>{{ $stock->appliance->model }}</td>
                                    <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                    <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                    <td>
                                        @if($stock->state == 0)
                                            <label class="label label-warning">Pending order</label>
                                        @elseif($stock->state == 1)
                                            <label class="label label-info">Order placed</label>
                                        @elseif($stock->state == 2)
                                            <label class="label label-success">In Stock</label>
                                        @elseif($stock->state == 3)
                                            <label class="label label-primary">Delivered</label>
                                        @else
                                            <label class="label label-danger">Exception</label>
                                        @endif
                                            {{ $stock->id }}/{{ $stock->shelf }}
                                    </td>
                                    <td>
                                        {{ $stock->price }}
                                        <a href="{{ url('appliance/stock/'.$stock->id.'/price') }}" class="btn btn-success pull-right">编辑</a>
                                    </td>
                                    <td>
                                        {{ $stock->warranty }} @if($stock->warranty)year(s)@endif
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

    <script type="text/javascript">
        $('.sid').select2({
            placeholder: 'Select an item',
            ajax: {
                url: '/select2-autocomplete-ajax/unsigned',
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

        $('.aid').select2({
            placeholder: 'Select an model',
            ajax: {
                url: '/select2-autocomplete-ajax/applianceModel',
                dataType: 'json',
                delay: 200,
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
@endsection
