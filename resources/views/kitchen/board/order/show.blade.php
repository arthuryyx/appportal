@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$order->ref}}</h1>
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
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Add</a></li>
                            <li><a data-toggle="tab" href="#menu1">New</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                {!! Form::open(['url' => 'kitchen/board/order/item','method'=>'POST']) !!}
                                </br><select id="selectBoard" class="form-control" name="stock_id" required="required"></select>
                                <p></p>
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::text('job_no', '', array('class' => 'form-control', 'placeholder' => 'Job No.')) }}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ Form::number('qty', '', array('class' => 'form-control', 'placeholder' => 'Qty', 'required' => 'required')) }}
                                    </div>
                                </div>
                                {{ Form::hidden('order_id', $order->id) }}
                                </br>
                                {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                                {!! Form::close() !!}

                            </div>
                            <div id="menu1" class="tab-pane fade">
                                {!! Form::open(['url' => 'kitchen/board/stock','method'=>'POST']) !!}
                                </br>{{ Form::select('brand', ['Prime' =>'Prime', 'Melteca' =>'Melteca', 'bestwood' =>'bestwood', 'Zealand' =>'Zealand'], null, ['class' => 'form-control', 'placeholder'=>'Brand', 'required' => 'required']) }}
                                </br>{{ Form::text('title', '', array('class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required')) }}
                                </br>{{ Form::select('size', ['2440X1220mm'=>'2440X1220mm', '2400X900mm'=>'2400X900mm', '2700x1220mm'=>'2700x1220mm', '3660X1220mm'=>'3660X1220mm', '3600X600mm'=>'3600X600mm'], null, ['class' => 'form-control', 'placeholder'=>'Size', 'required' => 'required']) }}
                                </br>{{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                                {!! Form::close() !!}

                            </div>

                        </div>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <table width="60%" class="table">
                            <thead>
                            <tr>
                                <th>Create Date</th>
                                <th>Created By</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                                <td>{{$order->getCreated_by->name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <form id="frm-example" name="frm_example" action="" method="post">
                    {{ csrf_field() }}
                    <div class="panel-heading">
                        <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('kitchen/board/arriving')}}'">Arrive</button>
                        <!-- Button trigger modal -->
                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target={{"#myModaldelete"}}>Delete</button>--}}
                        <!-- Modal -->
                        {{--<div class="modal fade" id={{"myModaldelete"}} tabindex="-1" role="dialog">--}}
                            {{--<div class="modal-dialog">--}}
                                {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}

                                        {{--<button type="submit" class="btn btn-danger" onclick="document.frm_example.action='{{ url('appliance/stock/delete')}}'">Confirm</button>--}}
                                        {{--<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!-- /.modal-content -->--}}
                            {{--</div>--}}
                            {{--<!-- /.modal-dialog -->--}}
                        {{--</div>--}}
                        {{--<!-- /.modal -->--}}
                    </div>
                    <div class="panel panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Board</th>
                                <th>Job No.</th>
                                <th>Qty</th>
                                <th>Arrived/Cancel</th>
                                <th>Remain</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->hasManyItem as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->getStock->brand . ', ' . $item->getStock->title . ', ' . $item->getStock->size}}</td>
                                    <td>{{ $item->job_no }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>
                                        {{ $item->hasManyArrive->where('value', '>', 0)->sum('value') }}
                                        @if($item->hasManyArrive->where('value', '<', 0)->sum('value')<0)
                                            /  {{$item->hasManyArrive->where('value', '<', 0)->sum('value')}}
                                        @endif
                                    </td>
                                    @if($item->remain>0)
                                    <td>
                                        {{ Form::number('qty['.$item->id.']', $item->remain, array('class' => 'form-control', 'placeholder' => 'Qty', 'max' => $item->remain, 'min' => 1)) }}
                                    </td>
                                    <td>
                                        <a href="{{ url('kitchen/board/order/item/'.$item->id) }}" class="btn btn-danger"> Cancel</a>
                                    </td>
                                    @else
                                        <td>0</td>
                                        <td></td>
                                    @endif
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
                ordering: false,
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
                $.each(rows_selected, function(index, item_id){
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'id[]')
                            .val(item_id)
                    );
                });
            });
        });
    </script>

    <script type="text/javascript">
        $('#selectBoard').select2({
            placeholder: 'Board',
            ajax: {
                url: '/kitchen/board/name-select2',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.brand + ' | ' + item.title + ' | ' + item.size,
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
