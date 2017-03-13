@extends('layouts.app')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Invoice Info</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! implode('<br>', $errors->all()) !!}
                    </div>
                @endif
                <div class="panel-body">
                    <table width="100%" class="table">
                        <thead>
                            <tr>
                                <th>Receipt No.</th>
                                <th>Data</th>
                                <th>Job</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$invoice->receipt_id}}</td>
                                <td>{{$invoice->created_at->format('d-m-Y')}}</td>
                                <td>{{$invoice->getCreated_by->name}}</td>
                                <td>{{$invoice->job_id}}</td>
                                <td>{{$invoice->customer_name}}</td>
                                <td>{{$invoice->address}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>

                    <div class="col-lg-4">
                        {!! Form::open(['url' => 'appliance/stock','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong>place new order</strong>
                                <select class="aid form-control" name="aid" required="required"></select>
                                <strong>quantity</strong>
                                {{ Form::number('mount', 1, array('class' => 'form-control')) }}
                                {{ Form::hidden('bulk', $invoice->id) }}
                                {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                <thead>
                <tr>
                    {{--<th>--}}
                    {{--Quantity--}}
                    {{--</th>--}}
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
                </tr>
                </thead>
                <tbody>
                @foreach ($invoice->hasManyInits as $stock)
                    <tr>
                        {{--<td>{{ $stock->total }}</td>--}}
                        <td>{{ $stock->appliance->model }}</td>
                        <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                        <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                        <td>
                            @if($stock->state == 0)
                                <label class="label label-warning">Pending payments</label>
                            @elseif($stock->state == 1)
                                <label class="label label-info">Order placed</label>
                            @elseif($stock->state == 2)
                                <label class="label label-success">In Stock</label>
                            @elseif($stock->state == 3)
                                <label class="label label-primary">Delivered</label>
                            @else
                                <label class="label label-danger">Exception</label>
                            @endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">

        $('.sid').select2({
            placeholder: 'Select an item',
            ajax: {
                url: '/select2-autocomplete-ajax/available',
                dataType: 'json',
                delay: 250,
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

    <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                responsive: true,
                order: [0, 'asc'],
                paging: false,
                searching: false
            });
        });
    </script>
@endsection
