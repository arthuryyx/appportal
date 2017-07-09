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
                    {{--@if($quotation->state == 0)--}}
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
                                            {{--<strong>${{array_sum($quotation->hasManyDeposits->pluck('amount')->all())}}</strong>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<form action="{{ url('appliance/invoice/paid') }}" method="POST" style="display: inline;">--}}
                                                {{--{{ csrf_field() }}--}}
                                                {{--<input type="hidden" name="id" value="{{$quotation->id}}">--}}
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
                    {{--<a href="{{ url('appliance/invoice/job/'.$quotation->id.'/html') }}" class="btn btn-primary" target="_blank">Print</a>--}}
{{--                    <a href="{{ url('appliance/invoice/job/'.$quotation->id.'/edit') }}" class="btn btn-success">Edit</a>--}}
                    <table width="100%" class="table">
                        <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$quotation->customer->first.' '.$quotation->customer->last}}</td>
                            <td>{{$quotation->customer->phone}}</td>
                            <td>{{$quotation->customer->mobile}}</td>
                            <td>{{$quotation->customer->email}}</td>
                            <td>{{$quotation->address->address}}</td>
                            <td>{{$quotation->created_at->format('d-m-Y')}}</td>
                            {{--<td>{{$quotation->getCreated_by->name}}</td>--}}
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    {{--<div class="col-lg-2">--}}
                        {{--@if($quotation->state == 0)--}}
                            {{--<img src="{{ asset('img/unpaid.png')}}" height="150" width="150">--}}
                        {{--@elseif($quotation->state == 1)--}}
                            {{--<img src="{{ asset('img/paid.png')}}" height="150" width="150" >--}}
                        {{--@endif--}}
                    {{--</div>--}}

                    {{--@if($quotation->state == 0)--}}
                        <div class="col-lg-4">
                            {!! Form::open(['url' => 'kitchen/quot/select','method'=>'POST']) !!}
                            <div class="row">
                                <div class="col-xs-10 col-sm-10 col-md-10">
                                    <strong>Product</strong>
                                    <select class="pid form-control" name="product_id" required="required"></select>
                                    {{--<strong>Price</strong>--}}
{{--                                    {{ Form::number('price', null, array('class' => 'form-control', 'step' => 'any')) }}--}}
                                    {{ Form::hidden('quotation_id', $quotation->id) }}
                                    {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        {{--@can('appliance_add_deposit')--}}
                            {{--<div class="col-lg-4">--}}
                                {{--{!! Form::open(['url' => 'appliance/deposit','method'=>'POST']) !!}--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-xs-10 col-sm-10 col-md-10">--}}
                                        {{--<strong>Deposit</strong>--}}
                                        {{--{{ Form::number('amount', null, array('class' => 'form-control', 'step' => 'any', 'required' => 'required')) }}--}}
                                        {{--{{ Form::hidden('invoice_id', $quotation->id) }}--}}
                                        {{--{{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--{!! Form::close() !!}--}}
                            {{--</div>--}}
                        {{--@endcan--}}
                    {{--@endif--}}

                    {{--<div class="col-lg-2">--}}
                        {{--<p>--}}
                            {{--<strong>Deposit History: </strong>--}}
                            {{--<a href="{{ url('appliance/deposit/index/'.$quotation->id) }}" class="btn btn-primary">view</a>--}}
                        {{--</p>--}}
                        {{--<hr>--}}
                        {{--<p>--}}
                            {{--<strong>Delivery History: </strong>--}}
                            {{--<a href="{{ url('appliance/delivery/index/'.$quotation->id) }}" class="btn btn-primary">view</a>--}}
                        {{--</p>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="panel panel-default">
                <form id="frm-example" name="frm_example" action="" method="post">
                    {{ csrf_field() }}

                    <div class="panel-heading">
                        {{--@can('appliance_order')--}}
                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/order')}}'">order</button>--}}
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
                                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/deliver/'.$quotation->id)}}'">deliver</button>--}}
                                            {{--<button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.modal-content -->--}}
                                {{--</div>--}}
                                {{--<!-- /.modal-dialog -->--}}
                            {{--</div>--}}
                            {{--<!-- /.modal -->--}}
                        {{--@endcan--}}
                    </div>
                    <div class="panel panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Model
                                </th>
                                <th>
                                    Type
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($quotation->products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product->model }}</td>
                                    <td>{{ $product->product->category->name }}</td>
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
        $('.pid').select2({
            placeholder: 'Select an model',
            ajax: {
                url: '/select2-autocomplete-ajax/productModel',
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
