@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$product->model}}</h1>
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
                <div class="panel-heading">
                    <a href="{{ url('product/model') }}" class="btn btn-primary">Back</a>
                    {{--<a href="{{ url('product/model/'.$product->id.'/edit') }}" class="btn btn-success">修改</a>--}}
                </div>
                <div class="panel panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                Part Name
                            </th>
                            <th>
                                Material Type
                            </th>
                            <th>
                                Qty
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($product->parts as $part)
                            <tr>
                                <td>{{ $part->name }}</td>
                                <td>{{ $part->materialTypes->implode('name', ', ') }}</td>
                                <td>{{ $part->pivot->qty }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('vendor/select2/select2.min.js')}}"></script>

    {{--<script type="text/javascript">--}}
        {{--$('.sid').select2({--}}
            {{--placeholder: 'Select an item',--}}
            {{--ajax: {--}}
                {{--url: '/select2-autocomplete-ajax/unsigned',--}}
                {{--dataType: 'json',--}}
                {{--delay: 200,--}}
                {{--processResults: function (data) {--}}
                    {{--return {--}}
                        {{--results:  $.map(data, function (item) {--}}
                            {{--return {--}}
                                {{--text: item.model + ' 【' + item.shelf + '】',--}}
                                {{--id: item.id--}}
                            {{--}--}}
                        {{--})--}}
                    {{--};--}}
                {{--},--}}
                {{--cache: true--}}
            {{--}--}}
        {{--});--}}

        {{--$('.aid').select2({--}}
            {{--placeholder: 'Select an model',--}}
            {{--ajax: {--}}
                {{--url: '/select2-autocomplete-ajax/applianceModel',--}}
                {{--dataType: 'json',--}}
                {{--delay: 200,--}}
                {{--processResults: function (data) {--}}
                    {{--return {--}}
                        {{--results:  $.map(data, function (item) {--}}
                            {{--return {--}}
                                {{--text: item.model,--}}
                                {{--id: item.id--}}
                            {{--}--}}
                        {{--})--}}
                    {{--};--}}
                {{--},--}}
                {{--cache: true--}}
            {{--}--}}
        {{--});--}}

    {{--</script>--}}

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
//                columnDefs: [
//                    {
//                        'targets': 0,
//                        'checkboxes': {
//                            'selectRow': true,
//                            'value': 1
//                        }
//                    }
//                ],
//                select: {
//                    'style': 'multi'
//                },
                order: [[1, 'asc']]
            });

            // Handle form submission event
//            $('#frm-example').on('submit', function(e){
//                var form = this;
//                var rows_selected = table.column(0).checkboxes.selected();
//
//                // Iterate over all selected checkboxes
//                $.each(rows_selected, function(index, sid){
//                    // Create a hidden element
//                    $(form).append(
//                        $('<input>')
//                            .attr('type', 'hidden')
//                            .attr('name', 'id[]')
//                            .val(sid)
//                    );
//                });
//            });
        });
    </script>
@endsection
