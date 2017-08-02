@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Job Info</h1>
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
                        {{--@can('kitchen_confirm_quotation')--}}
                            {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target={{"#myModalpayment"}}>Approve</button>--}}
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
                                            {{--<form action="{{ url('kitchen/quot/approve') }}" method="POST" style="display: inline;">--}}
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
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$job->quotation->customer->first.' '.$job->quotation->customer->last}}</td>
                            <td>{{$job->quotation->customer->phone}}</td>
                            <td>{{$job->quotation->customer->mobile}}</td>
                            <td>{{$job->quotation->customer->email}}</td>
                            <td>{{$job->quotation->address->address}}</td>
                            <td>{{$job->created_at->format('d-m-Y')}}</td>
                            <td>{{$job->total}}</td>
                            {{--<td>{{$quotation->getCreated_by->name}}</td>--}}
                        </tr>
                        </tbody>
                    </table>
                    <hr>

                    {{--@if($quotation->state == 0)--}}
                        {{--<div class="col-lg-12">--}}
                            {{--{!! Form::open(['url' => 'kitchen/quot/select','method'=>'POST']) !!}--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-xs-3 col-sm-3 col-md-3">--}}
                                    {{--<strong>Product</strong>--}}
                                    {{--<select class="pid form-control" name="product_id" required="required"></select>--}}
                                    {{--<strong>Price</strong>--}}
{{--                                    {{ Form::number('price', null, array('class' => 'form-control', 'step' => 'any')) }}--}}
                                    {{--{{ Form::hidden('quotation_id', $quotation->id) }}--}}
                                {{--</div>--}}
                                {{--<div id="selectparts" class="col-xs-9 col-sm-9 col-md-9"></div>--}}
                            {{--</div>--}}
                            {{--{!! Form::close() !!}--}}
                        {{--</div>--}}

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
                    {{--@elseif($quotation->state == 1)--}}
                        {{--<div class="col-lg-2">--}}
                            {{--<img src="{{ asset('img/approved.png')}}" height="150" width="150" >--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-2">--}}
                            {{--<a href="{{ url('kitchen/job/create/'.$quotation->id) }}" class="btn btn-primary btn-lg">Create Job</a>--}}
                        {{--</div>--}}
                        {{--@elseif($quotation->state == 3)--}}
                        {{--<div class="col-lg-2">--}}
                            {{--<img src="{{ asset('img/approved.png')}}" height="150" width="150" >--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-2">--}}
                            {{--<a href="{{ url('kitchen/job/'.$quotation->job->id) }}" class="btn btn-primary btn-lg">Go Job</a>--}}
                        {{--</div>--}}
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
                    {{--{!! Form::hidden('qid', $quotation->id) !!}--}}
                    {{--@if($quotation->state == 0)--}}
                    {{--<div class="panel-heading">--}}
                        {{--@can('appliance_order')--}}
                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/order')}}'">order</button>--}}
                        {{--@endcan--}}
{{--                        @can('appliance_release')--}}
                        {{--<!-- Button trigger modal -->--}}
                            {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target={{"#myModalrelease"}}>Delete</button>--}}
                            {{--<!-- Modal -->--}}
                            {{--<div class="modal fade" id={{"myModalrelease"}} tabindex="-1" role="dialog">--}}
                                {{--<div class="modal-dialog">--}}
                                    {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                            {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body">--}}
                                            {{--Confirm delete item(s) from current job!--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('kitchen/product/delete')}}'">delete</button>--}}
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
                    {{--</div>--}}
                    {{--@endif--}}
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
                                <th>
                                    Materials
                                </th>
                                <th>
                                    Price
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($job->products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product->model }}</td>
                                    <td>{{ $product->product->category->name }}</td>
                                    <td>
                                        @foreach ($product->materials as $material)
                                            {{$material->item->model}} x {{$material->qty}} = ${{$material->item->price * $material->qty}}</br>
                                        @endforeach
                                    </td>
                                    <td>{{ $product->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            {{--<tfoot><tr><td></td><td></td><td></td><td></td><td><strong>Total: {{ $quotation->products->sum('price') }}</strong></td></tr></tfoot>--}}
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
        }).on('change', function() {
//            alert();
            $.ajax({
                url: 'select-ajax',
                method: 'POST',
                data: {model_id:this.value, _token:$("input[name='_token']").val()},
                success: function(data) {
//                    console.log(data);
                    $('#selectparts').html('');
                    $('#selectparts').html(data)
                },
                error: function (e) {
                    alert(e);
                }
            });
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
//                order: [[1, 'asc']]
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
