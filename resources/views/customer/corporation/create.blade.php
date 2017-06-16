@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">New Corporation Customer</h2>
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
                    {!! Form::open(['url' => 'customer/corporation','method'=>'POST']) !!}
                    <div class="row">

                        {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                                {{--<label>{!! Form::radio('type', 0, true ) !!}--}}
                                    {{--Individual--}}
                                {{--</label>--}}
                                {{--<label>{!! Form::radio('type', 1 ) !!}--}}
                                    {{--Corporation--}}
                                {{--</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>company name:</strong>
                                {!! Form::text('first', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>phone:</strong>
                                {!! Form::number('phone', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>mobile:</strong>
                                {!! Form::number('mobile', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>email:</strong>
                                {!! Form::email('email', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>street:</strong>
                                {!! Form::text('street', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>sub:</strong>
                                {!! Form::text('sub', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>city:</strong>
                                {!! Form::text('city', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>zip:</strong>
                                {!! Form::number('zip', null, array('class' => 'form-control', 'required' => 'required')) !!}
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