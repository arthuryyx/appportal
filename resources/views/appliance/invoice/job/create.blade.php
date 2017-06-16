@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">New Invoice</h2>
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
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif
                        {!! Form::open(['url' => 'appliance/invoice/job','method'=>'POST']) !!}
                        <div class="row">

                            {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                                {{--<div class="form-group">--}}
                                    {{--<strong>receipt_id:</strong>--}}
                                    {{--{!! Form::text('receipt_id', null, array('class' => 'form-control', 'required' => 'required')) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>job_id:</strong>
                                    {!! Form::text('job_id', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>final price:</strong>
                                    {!! Form::number('price', null, array('class' => 'form-control', 'step' => 'any', 'min' => '0', 'required' => 'required')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>customer_name:</strong>
                                    {!! Form::text('customer_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>address:</strong>
                                    {!! Form::text('address', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>

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