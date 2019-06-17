@extends('layouts.app')

@section('css')
    <!-- DataTables CSS -->
    <link href="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Appliance Job Invoices List</h1>
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
                    <a href="{{ url('appliance/invoice/job/create') }}" class="btn btn-primary" target="_blank">New</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                receipt_id
                            </th>
                            <th>
                                job_id
                            </th>
                            <th>
                                customer_name
                            </th>
                            <th>
                                address
                            </th>
                            <th>
                                phone
                            </th>
                            <th>
                                created_by
                            </th>
                            <th>
                                final price
                            </th>
                            <th>
                                created_at
                            </th>
                            <th>
                                state
                            </th>
                            <th></th>
                            {{--<th></th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->receipt_id }}</td>
                                <td>{{ $invoice->job_id }}</td>
                                <td>{{ $invoice->customer_name }}</td>
                                <td>{{ $invoice->address }}</td>
                                <td>{{ $invoice->phone }}</td>
                                <td>{{ $invoice->getCreated_by->name }}</td>
                                <td>{{ $invoice->price }}</td>
                                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @if($invoice->price != 0)
                                        <label class="label label-info">&nbsp;&nbsp;&nbsp;{{round((1-$invoice->getMargin->sum('appliance.lv4')/$invoice->price)*100, 2).'%'}}&nbsp;&nbsp;&nbsp;</label>
                                    @endif

                                    @if($invoice->price == 0)
                                        <label class="label label-warning">&nbsp;&nbsp;&nbsp;${{$invoice->hasManyDeposits->sum('amount')}}&nbsp;&nbsp;&nbsp;</label>
                                    @elseif($invoice->hasManyDeposits->sum('amount')==$invoice->price)
                                        <label class="label label-success">&nbsp;&nbsp;&nbsp;Paid&nbsp;&nbsp;&nbsp;</label>
                                    @elseif($invoice->hasManyDeposits->count() == 0)
                                        <label class="label label-danger">&nbsp;Unpaid&nbsp;</label>
                                    @else
                                        <label class="label label-warning">&nbsp;&nbsp;&nbsp;&nbsp;{{round(($invoice->hasManyDeposits->sum('amount')/$invoice->price)*100).'%'}}&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    @endif

                                    @if($invoice->hasManyStocks->count() == 0)
                                        <label class="label label-warning">&nbsp;&nbsp;Empty&nbsp;&nbsp;</label>
                                    @elseif($invoice->getState->count() == 0)
                                        <label class="label label-success">Delivered</label>
                                    @elseif($invoice->getState->count() > 0)
                                        <label class="label label-danger">&nbsp;&nbsp;&nbsp;Hold&nbsp;&nbsp;&nbsp;</label>
                                    @else
                                        <label class="label label-primary">Exception</label>
                                    @endif
                                </td>
                                <td><a href="{{ url('appliance/invoice/job/'.$invoice->id) }}" class="btn btn-success" target="_blank">详情</a></td>
                                {{--<td><a href="{{ url('appliance/invoice/job/'.$invoice->id.'/edit') }}" class="btn btn-success" target="_blank">修改</a></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
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
    <script src="{{ asset('vendor/datatables-plugins/date-eu.js')}}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                autoWidth: false,
                columnDefs: [
                    { "width": "15%", "targets": 8 },
                    { type: 'date-eu', targets: 7 }
                ],
//                responsive: true,
                pageLength: 100,
                order: [7]
            });
        });
    </script>
@endsection