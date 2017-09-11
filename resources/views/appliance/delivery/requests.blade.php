@extends('layouts.app')

@section('css')
    <!-- DataTables CSS -->
    {{--<link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">--}}

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/datatables-checkboxes/dataTables.checkboxes.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Request</h1>
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
                <form id="frm-example" name="frm_example" action="" method="post">
                    {{ csrf_field() }}
                    @can('dev')
                    <div class="panel-heading">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target={{"#myModalmerge"}}>Merge</button>
                        <!-- Modal -->
                        <div class="modal fade" id={{"myModalmerge"}} tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                        <h3>Bulk</h3>
                                    </div>
                                    <div class="modal-body">
                                        <strong>Order Ref.</strong>
                                        <input type="text" name="ref" class="form-control">
                                        <strong>Comment</strong>
                                        <textarea name="comment" class="form-control"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" onclick="document.frm_example.action='{{ url('appliance/order/merge')}}'">merge</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>
                    @endcan
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                {{--<th>--}}
                                    {{--Quantity--}}
                                {{--</th>--}}
                                <th></th>
                                <th>
                                    invoice_id
                                </th>
                                <th>
                                    job_id
                                </th>
                                <th>
                                    request by
                                </th>
                                <th>
                                    request date
                                </th>
                                <th>
                                    schedule date
                                </th>
                                <th>
                                    state
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dispatches as $dr)
                                <tr>
                                    <td>{{ $dr->id }}</td>
                                    <td>{{ $dr->getInvoice->receipt_id }}</td>
                                    <td>{{ $dr->getInvoice->job_id }}</td>
                                    <td>{{ $dr->getCreated_by->name }}</td>
                                    <td>{{ $dr->date }}</td>
                                    <td>{{ $dr->getSchedule?$dr->getSchedule->date:null }}</td>
                                    <td>
                                        {{--@if($stock->assign_to != null)--}}
                                            {{ $dr->state }}
                                        {{--@endif--}}
                                    </td>
{{--                                    <td><a href="{{ url('appliance/invoice/job/'.$dr->getAssignTo->id) }}" class="btn btn-success">查看</a></td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </form>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

@endsection

@section('js')
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
                    },
                    { type: 'date-eu', targets: 4 },
                    { type: 'date-eu', targets: 5 }

                ],
                select: {
                    'style': 'multi'
                },
                order: [[3, 'asc']]
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