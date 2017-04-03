@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Display List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!! implode('<br>', $errors->all()) !!}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-body">
                    @can('root')
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            {!! Form::open(['url' => 'appliance/stock/display','method'=>'POST']) !!}
                            <strong>from stock</strong>
                            <select class="sid form-control" name="sid" required="required"></select>
                            {{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel panel-body">
                    <form id="frm-example" name="frm_example" action="" method="post">
                        {{ csrf_field() }}
                        {{--@can('root')--}}
                            {{--<button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/stock/release')}}'">order</button>--}}
                        {{--@endcan--}}
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
                                    Shelf
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->id }}</td>
                                    <td>{{ $stock->appliance->model }}</td>
                                    <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                                    <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                                    <td>{{ $stock->shelf }}</td>
                                    <td><a href="{{ url('appliance/stock/'.$stock->id.'/edit') }}" class="btn btn-success">编辑</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
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
