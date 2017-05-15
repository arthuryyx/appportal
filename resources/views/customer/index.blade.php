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
            <h1 class="page-header">Customer List</h1>
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
                    <a href="{{ url('customer/create') }}" class="btn btn-primary ">New</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>
                                first name
                            </th>
                            <th>
                                last name
                            </th>
                            <th>
                                type
                            </th>
                            <th>
                                phone
                            </th>
                            <th>
                                mobile
                            </th>
                            <th>
                                email
                            </th>

                            <th>
                                street
                            </th>
                            <th>
                                sub
                            </th>
                            <th>
                                city
                            </th>
                            <th>
                                zip
                            </th>
                            <th>
                                comment
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->first }}</td>
                                <td>{{ $customer->last }}</td>
                                <td>
                                    @if($invoice->type == 0)

                                    @elseif($invoice->state == 1)
                                        <label class="label label-success">&nbsp;&nbsp;Company&nbsp;&nbsp;</label>
                                    @else
                                        <label class="label label-primary">Exception</label>
                                    @endif
                                </td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->mobile }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->street }}</td>
                                <td>{{ $customer->sub }}</td>
                                <td>{{ $customer->city }}</td>
                                <td>{{ $customer->zip }}</td>
                                <td>{{ $customer->comment }}</td>

                                <td><a href="{{ url('appliance/invoice/job/'.$invoice->id) }}" class="btn btn-success">详情</a></td>
                                {{--<td><a href="{{ url('appliance/invoice/job/'.$invoice->id.'/edit') }}" class="btn btn-success">修改</a></td>--}}
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
    {{--<script src="{{ asset('vendor/datatables-plugins/date-eu.js')}}"></script>--}}
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
//                columnDefs: [
//                    { "width": "25%", "targets": 3 }
////                    { type: 'date-eu', targets: 5 }
//                ],
                responsive: true,
                pageLength: 100,
                order: [0]
            });
        });
    </script>
@endsection