@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Quote Info</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! implode('<br>', $errors->all()) !!}
        </div>
    @elseif ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ $message }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {{--@if($quote->state == 0)--}}
                        {{--@can('appliance_confirm_payment')--}}
                            {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target={{"#myModalpayment"}}>Payment</button>--}}
                            {{--<!-- Modal -->--}}
                            {{--<div class="modal fade" id={{"myModalpayment"}} tabindex="-1" role="dialog">--}}
                                {{--<div class="modal-dialog">--}}
                                    {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                            {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body">--}}
                                            {{--<strong>${{$quote->hasManyDeposits->sum('amount')}}</strong>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<form action="{{ url('appliance/invoice/paid') }}" method="POST" style="display: inline;">--}}
                                                {{--{{ csrf_field() }}--}}
                                                {{--<input type="hidden" name="id" value="{{$quote->id}}">--}}
                                                {{--<button type="submit" class="btn btn-danger">confirm</button>--}}
                                                {{--<button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>--}}
                                            {{--</form>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.modal-content -->--}}
                                {{--</div>--}}
                                {{--<!-- /.modal-dialog -->--}}
                            {{--</div>--}}
                            {{--<!-- /.modal -->--}}
                        {{--@endcan--}}
                    {{--@endif--}}
                    <a href="{{ url('appliance/quote/'.$quote->id.'/html') }}" class="btn btn-primary" target="_blank">Print</a>
                    <a href="{{ url('appliance/quote/'.$quote->id.'/edit') }}" class="btn btn-success">Edit</a>
                    <table width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Quote No.</th>
                                <th>Vaild Until</th>
                                <th>Created_by</th>
                                <th>Total Price</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Shipping Address</th>
                                <th>Comment</th>
                                {{--<th>Deliver Fee</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$quote->quote_no}}</td>
                                <td>{{date('d/M/Y', strtotime('+30 days', strtotime($quote->created_at)))}}</td>
                                <td>{{$quote->getCreated_by->name}}</td>
                                <td>{{$quote->price}}</td>
                                <td>{{$quote->customer_name}}</td>
                                <td>{{$quote->phone}}</td>
                                <td>{{$quote->email}}</td>
                                <td>{{$quote->address}}</td>
                                <td>{{$quote->comment}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="col-lg-4">
                        {!! Form::open(['url' => 'appliance/item/create','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-10 col-sm-10 col-md-10">
                                <strong>Appliance</strong>
                                <select class="aid form-control" name="aid" required="required"></select>
                                <strong>Price</strong>
                                {{ Form::number('price', null, array('class' => 'form-control', 'step' => 'any')) }}
                                <strong>Warranty (year)</strong>
                                {{ Form::number('warranty', null, array('class' => 'form-control')) }}
                                {{ Form::hidden('quote_id', $quote->id) }}
                                {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <form id="frm-example" name="frm_example" action="" method="post">
                    {{--{{ csrf_field() }}--}}

                    {{--<div class="panel-heading">--}}
                        {{--@can('appliance_order')--}}
                        {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/order/'.$quote->id)}}'">order</button>--}}
                        {{--@endcan--}}
                        {{--@can('appliance_switch')--}}
                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/switch')}}'">switch</button>--}}
                        {{--@endcan--}}
                        {{--@can('appliance_release')--}}
                        {{--<!-- Button trigger modal -->--}}
                        {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModalrelease"}}>release</button>--}}
                        {{--<!-- Modal -->--}}
                        {{--<div class="modal fade" id={{"myModalrelease"}} tabindex="-1" role="dialog">--}}
                            {{--<div class="modal-dialog">--}}
                                {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body">--}}
                                        {{--Confirm release appliance from current job!--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-footer">--}}
                                        {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/release')}}'">release</button>--}}
                                        {{--<button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!-- /.modal-content -->--}}
                            {{--</div>--}}
                            {{--<!-- /.modal-dialog -->--}}
                        {{--</div>--}}
                        {{--<!-- /.modal -->--}}
                        {{--@endcan--}}
                        {{--@can('appliance_request_delivery')--}}
                        {{--<!-- Button trigger modal -->--}}
                            {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModalRequest"}}>request</button>--}}
                            {{--<!-- Modal -->--}}
                            {{--<div class="modal fade" id={{"myModalRequest"}} tabindex="-1" role="dialog">--}}
                                {{--<div class="modal-dialog">--}}
                                    {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                            {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<strong>Date</strong>--}}
                                                {{--<input type="datetime-local" name="date" class="form-control">--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group">--}}
                                                {{--<strong>shipping fee:</strong>--}}
                                                {{--{!! Form::number('fee', 0, array('class' => 'form-control', 'step' => 'any', 'min' => '0', 'required' => 'required')) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group">--}}
                                                {{--<strong>Post</strong>--}}
                                                {{--{{ Form::checkbox('post', 1, false, array('class' => 'name checkbox-inline')) }}--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group">--}}
                                                {{--<strong>comment:</strong>--}}
                                                {{--{!! Form::textarea('comment', null, array('class' => 'form-control')) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/delivery/request/'.$quote->id)}}'">request</button>--}}
                                            {{--<button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.modal-content -->--}}
                                {{--</div>--}}
                                {{--<!-- /.modal-dialog -->--}}
                            {{--</div>--}}
                            {{--<!-- /.modal -->--}}
                        {{--@endcan--}}
                        {{--@can('appliance_deliver')--}}
                        {{--<!-- Button trigger modal -->--}}
                        {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModaldeliver"}}>deliver</button>--}}
                        {{--<!-- Modal -->--}}
                        {{--<div class="modal fade" id={{"myModaldeliver"}} tabindex="-1" role="dialog">--}}
                            {{--<div class="modal-dialog">--}}
                                {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body">--}}
                                        {{--<strong>Carrier</strong>--}}
                                        {{--<input type="text" name="carrier" class="form-control">--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-footer">--}}
                                        {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/deliver/'.$quote->id)}}'">deliver</button>--}}
                                        {{--<button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!-- /.modal-content -->--}}
                            {{--</div>--}}
                            {{--<!-- /.modal-dialog -->--}}
                        {{--</div>--}}
                        {{--<!-- /.modal -->--}}
                        {{--@endcan--}}
                    {{--</div>--}}
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
                                {{--<th>--}}
                                    {{--State--}}
                                {{--</th>--}}
                                <th>
                                    Price
                                </th>
                                <th>
                                    Warranty
                                </th>
                                <th></th>
                             </tr>
                            </thead>
                            <tbody>
                            @foreach ($quote->hasManyItems as $item)
                                <tr>
                                    {{--<td>{{ $item->total }}</td>--}}
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->getAppliance->model }}</td>
                                    <td>{{ $item->getAppliance->belongsToBrand->name }}</td>
                                    <td>{{ $item->getAppliance->belongsToCategory->name }}</td>
                                    {{--<td>--}}
                                        {{--@if($item->state == 0)--}}
                                            {{--<label class="label label-warning">Pending order</label>--}}
                                        {{--@elseif($item->state == 1)--}}
                                            {{--<label class="label label-info">Order placed</label>--}}
                                        {{--@elseif($item->state == 2)--}}
                                            {{--<label class="label label-success">In Stock</label>--}}
                                        {{--@elseif($item->state == 3)--}}
                                            {{--<label class="label label-primary">Delivered</label>--}}
                                        {{--@else--}}
                                            {{--<label class="label label-danger">Exception</label>--}}
                                        {{--@endif--}}
                                            {{--{{ $item->id }}/{{ $item->shelf }}--}}
                                    {{--</td>--}}
                                    <td>
                                        {{ $item->price }}
                                    </td>
                                    <td>
                                        {{ $item->warranty }} @if($item->warranty)year(s)@endif
                                    </td>
                                    <td>
                                        <a href="{{ url('appliance/item/'.$item->id.'/edit') }}" class="btn btn-success pull-right">编辑</a>
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

        $('.aid').select2({
            placeholder: 'Type a model',
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
