@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>编辑失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                        {!! Form::model($order, ['method' => 'PATCH','route' => ['order.update', $order->id]]) !!}
                        <div class="row">
                            @if($order->invoice_id)
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ref:</strong>
                                        {!! Form::text(null,  $order->getInvoice->receipt_id.'.'.$order->ref, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                                    </div>
                                </div>
                            @else
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ref:</strong>
                                        {!! Form::text('ref', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                            @endif

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>comment:</strong>
                                    {!! Form::textarea('comment', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <a href="{{ url()->previous()}}" class="btn btn-danger">Cancel</a>
                                {{Form::submit('Submit', ['class' => 'btn btn-success pull-right'])}}
                            </div>
                        </div>
                        {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection