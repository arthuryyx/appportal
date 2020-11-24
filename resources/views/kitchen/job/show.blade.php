@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection
@section('content')
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
   <h1>{{ $job->job }}</h1>
   <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-lg-8">
                        <table width="100%" class="table">
                            <thead>
                            <tr>
                                <th>
                                    <a href="{{ url('kitchen/job/'.$job->id.'/edit') }}" class="btn btn-warning">Edit</a>
                                </th>
                                <th>Ref</th>
                                <th>Data</th>
                                <th>Created_by</th>
                                <th>Total</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    {{--                                <a href="{{ url('appliance/invoice/job/'.$job->id.'/html') }}" class="btn btn-primary" target="_blank">Print</a>--}}
                                </td>
                                <td>{{$job->ref}}</td>
                                <td>{{$job->created_at->format('d-m-Y')}}</td>
                                <td>{{$job->getCreated_by->name}}</td>
                                <td>{{$job->price}}</td>
                                <td>{{$job->customer_name}}</td>
                                <td>{{$job->phone}}</td>
                                <td>{{$job->email}}</td>
                                <td>{{$job->address}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-lg-2">
                                <br>
                                <br>
                                @if($job->price == 0 )

                                @elseif($job->getPayments->count() == 0)
                                    <img src="{{ asset('img/unpaid.png')}}" height="150">
                                @elseif($job->getPayments->sum('amount') == $job->price)
                                    <img src="{{ asset('img/paid.png')}}" height="150">
                                @else
                                    <img src="{{ asset('img/partially.png')}}" height="150">
                                @endif
                            </div>
                            {{--<div class="col-lg-4">--}}
                                {{--{!! Form::open(['url' => 'appliance/job/detail','method'=>'POST']) !!}--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-xs-10 col-sm-10 col-md-10">--}}
                                        {{--<strong>Model</strong>--}}
                                        {{--{{ Form::select('model_id', [], null, ['id' => 'model_id', 'class' => 'form-control', 'required' => 'required']) }}--}}
                                        {{--</br>--}}
                                        {{--</br>--}}
                                        {{--<strong>Price</strong>--}}
                                        {{--{{ Form::number('price', null, array('class' => 'form-control', 'step' => 'any', 'required' => 'required')) }}--}}
                                        {{--</br>--}}
                                        {{--<strong>Warranty (year)</strong>--}}
                                        {{--{{ Form::number('warranty', null, array('class' => 'form-control')) }}--}}
                                        {{--{{ Form::hidden('job_id', $job->id) }}--}}
                                        {{--</br>--}}
                                        {{--{{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--{!! Form::close() !!}--}}
                            {{--</div>--}}
                            {{--@endif--}}

                            <div class="col-lg-5">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="modelTables">

                                </table>
                            </div>
                        </div>

                        {{--<div class="col-lg-3">--}}
                        {{--{!! Form::open(['url' => 'appliance/stock/job/assign','method'=>'POST']) !!}--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-xs-10 col-sm-10 col-md-10">--}}
                        {{--<strong>from stock</strong>--}}
                        {{--<select class="sid form-control" name="sid" required="required"></select>--}}
                        {{--{{ Form::hidden('assign_to', $job->id) }}--}}
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
                        {{--{{ Form::hidden('job', $job->id) }}--}}
                        {{--{{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--{!! Form::close() !!}--}}
                        {{--</div>--}}

                        {{--                    @if($job->hasManyDeposits->count() == 0 || Gate::check('root'))--}}






                        {{--<div class="col-lg-2">--}}
                        {{--<p>--}}
                        {{--<strong>Deposit History: </strong>--}}
                        {{--<a href="{{ url('appliance/deposit/index/'.$job->id) }}" class="btn btn-primary">view</a>--}}
                        {{--</p>--}}
                        {{--</br>--}}
                        {{--<p>--}}
                        {{--<strong>Shipping Info: </strong>--}}
                        {{--<a href="{{ url('appliance/delivery/index/'.$job->id) }}" class="btn btn-primary">view</a>--}}
                        {{--</p>--}}
                        {{--</br>--}}
                        {{--<p>--}}
                        {{--<strong>Job Orders: </strong>--}}
                        {{--<a href="{{ url('appliance/job/order/'.$job->id) }}" class="btn btn-primary">view</a>--}}
                        {{--</p>--}}
                        {{--</div>--}}


                    </div>
                    <div class="col-lg-4">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Remark</a></li>
                            <li><a data-toggle="tab" href="#menu1">${{$job->getPayments->sum('amount')}} Paid</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <br>
                                {!! Form::open(['url' => 'kitchen/job/'.$job->id.'/remark','method'=>'POST']) !!}
                                    <div class="input-group">
                                        {{ Form::text('content', '', array('class' => 'form-control', 'placeholder' => '', 'required' => 'required')) }}
                                        <span class="input-group-btn">
                                                {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
                                            </span>
                                    </div>
                                {!! Form::close() !!}
                                <div style="height:270px; overflow:auto;">
                                    <table width="100%" class="table table-striped table-hover">
                                        @foreach($job->getRemarks as $remark)
                                            <tr><th>{{ $remark->content }}</th>
                                                <th>{{ $remark->getCreated_by->name }}</th>
                                                <th>{{ $remark->created_at->format('d/m/Y') }}</th>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <br>
                                {!! Form::open(['url' => 'kitchen/payment','method'=>'POST']) !!}
                                    <div class="input-group" style="width: 200px">
                                        {{ Form::number('amount', null, array('class' => 'form-control', 'step' => 'any', 'required' => 'required')) }}
                                        {{ Form::hidden('job_id', $job->id) }}
                                        <span class="input-group-btn">
                                            {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
                                        </span>
                                    </div>
                                {!! Form::close() !!}
                                <div style="height:270px; overflow:auto;">
                                    <table width="100%" class="table table-striped table-hover">
                                        @foreach($job->getPayments as $payment)
                                            <tr>
                                                <th>
                                                    @if($payment->amount > 0)
                                                        ${{ $payment->amount }}
                                                    @else
                                                        -${{ -$payment->amount }}
                                                    @endif
                                                </th>
                                                <th>{{ $payment->getCreated_by->name }}</th>
                                                <th>{{ $payment->created_at->format('d/m/Y H:m:s') }}</th>
                                                @can('root')
                                                    <th>
                                                        <button class="btn btn-warning center-block" data-toggle="modal" data-target={{"#myModal".$payment->id}}>Edit</button>
                                                    </th>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id={{"myModal".$payment->id}} tabindex="-1" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <h5>修改金额</h5>
                                                                    <div class="col-lg-offset-2 col-lg-7">
                                                                        {!! Form::model($payment, ['method' => 'PATCH', 'url' => 'kitchen/payment/'.$payment->id]) !!}
                                                                        <div class="input-group">
                                                                            {{ Form::number('amount', null, array('class' => 'form-control', 'step' => 'any')) }}
                                                                            <span class="input-group-btn">
                                                                                {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
                                                                            </span>
                                                                        </div>
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="col-lg-12">--}}

            {{--<div class="panel panel-default">--}}
                {{--<form id="frm-example" name="frm_example" action="" method="post">--}}
                    {{--{{ csrf_field() }}--}}

                    {{--<div class="panel-heading">--}}
                        {{--@can('appliance_order')--}}
                        {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/order/'.$job->id)}}'">order</button>--}}
                        {{--@endcan--}}
                        {{--@can('appliance_switch')--}}
                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/switch')}}'">switch</button>--}}
                        {{--@endcan--}}
                        {{--@can('appliance_release')--}}
                        {{--<!-- Button trigger modal -->--}}
                        {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalrelease">release</button>--}}
                        {{--<!-- Modal -->--}}
                        {{--<div class="modal fade" id="myModalrelease" tabindex="-1" role="dialog">--}}
                            {{--<div class="modal-dialog">--}}
                                {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body">--}}
                                        {{--Confirm release appliance from current job!--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-footer">--}}
                                        {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/release')}}'">confirm</button>--}}
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
                            {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalRequest">request</button>--}}
                            {{--<!-- Modal -->--}}
                            {{--<div class="modal fade" id="myModalRequest" tabindex="-1" role="dialog">--}}
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
                                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/delivery/request/'.$job->id)}}'">request</button>--}}
                                            {{--<button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.modal-content -->--}}
                                {{--</div>--}}
                                {{--<!-- /.modal-dialog -->--}}
                            {{--</div>--}}
                            {{--<!-- /.modal -->--}}
                        {{--@endcan--}}
                        {{--@can('appliance_restock')--}}
                        {{--<!-- Button trigger modal -->--}}
                            {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalrestock">restock</button>--}}
                            {{--<!-- Modal -->--}}
                            {{--<div class="modal fade" id="myModalrestock" tabindex="-1" role="dialog">--}}
                                {{--<div class="modal-dialog">--}}
                                    {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                            {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body">--}}
                                            {{--Confirm Restock appliance!--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/restock')}}'">confirm</button>--}}
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
                        {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModaldeliver">deliver</button>--}}
                        {{--<!-- Modal -->--}}
                        {{--<div class="modal fade" id="myModaldeliver" tabindex="-1" role="dialog">--}}
                            {{--<div class="modal-dialog">--}}
                                {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body">--}}
                                        {{--<strong>Carrier</strong>--}}
                                        {{--<input type="text" name="carrier" class="form-control", placeholder="">--}}
                                        {{--<strong>Warehouse</strong>--}}
                                        {{--{{ Form::select('region', $region, null, array('class' => 'form-control', 'placeholder'=>'', 'required' => 'required')) }}--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-footer">--}}
                                        {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/deliver/'.$job->id)}}'">deliver</button>--}}
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
                    {{--<div class="panel panel-body">--}}
                        {{--<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>--}}
                                {{--Quantity--}}
                                {{--</th>--}}
                                {{--<th></th>--}}
                                {{--<th>--}}
                                    {{--Model--}}
                                {{--</th>--}}
                                {{--<th>--}}
                                    {{--Brand--}}
                                {{--</th>--}}
                                {{--<th>--}}
                                    {{--Category--}}
                                {{--</th>--}}
                                {{--<th>--}}
                                    {{--State--}}
                                {{--</th>--}}
                                {{--<th>--}}
                                    {{--Price--}}
                                {{--</th>--}}
                                {{--<th>--}}
                                    {{--Warranty--}}
                                {{--</th>--}}
                             {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@foreach ($job->getDetails as $detail)--}}
                                {{--<tr>--}}
                                    {{--<td>{{ $detail->id }}</td>--}}
                                    {{--<td>{{ $detail->getModel->model }}</td>--}}
                                    {{--<td>{{ $detail->getModel->brand }}</td>--}}
                                    {{--<td>{{ $detail->getModel->category }}</td>--}}
                                    {{--<td>--}}
                                        {{--@if($detail->state == 0)--}}
                                            {{--<label class="label label-warning">Pending order</label>--}}
                                        {{--@elseif($detail->state == 1)--}}
                                            {{--<label class="label label-info">Order placed</label>--}}
                                        {{--@elseif($detail->state == 2)--}}
                                            {{--<label class="label label-success">In Stock</label>--}}
                                        {{--@elseif($detail->state == 3)--}}
                                            {{--<label class="label label-primary">Delivered</label>--}}
                                        {{--@elseif($detail->state == 4)--}}
                                            {{--<label class="label label-info">In Transit</label>--}}
                                        {{--@else--}}
                                            {{--<label class="label label-danger">Exception</label>--}}
                                        {{--@endif--}}
                                            {{--{{ $detail->id }}/{{ $detail->shelf }}--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--{{ $detail->price }}--}}
{{--                                        <a href="{{ url('appliance/stock/'.$detail->id.'/price') }}" class="btn btn-success pull-right">编辑</a>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--{{ $detail->warranty }} @if($detail->warranty)year(s)@endif--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

@endsection

@section('js')
    <script src="{{ asset('vendor/select2/select2.min.js')}}"></script>

    <script type="text/javascript">
//        $('.sid').select2({
//            placeholder: 'Select an item',
//            ajax: {
//                url: '/select2-autocomplete-ajax/unsigned',
//                dataType: 'json',
//                delay: 200,
//                processResults: function (data) {
//                    return {
//                        results:  $.map(data, function (item) {
//                            return {
//                                text: item.model + ' 【' + item.shelf + '】',
//                                id: item.id
//                            }
//                        })
//                    };
//                },
//                cache: true
//            }
//        });

        $('#model_id').select2({
            placeholder: 'Select a model',
            ajax: {
                url: '/select2/appliance/model',
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
        })
        .on('select2:select', function (e) {
            $.ajax({
                url: '/admin/app/model/' + e.params.data.id,
                method: 'GET',
                success: function(data) {
                    $('#modelTables').html('');
                    $('#modelTables').html(data);
                },
                error: function (e) {
                    console.log(e);
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
