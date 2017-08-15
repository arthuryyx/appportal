@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">New {{ $type->name }}</h2>
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
                        {!! Form::open(['url' => 'material/item','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Model:</strong>
                                    {!! Form::text('model', null, array('placeholder' => 'Model','class' => 'form-control')) !!}
                                </div>
                            </div>

                            {!! Form::hidden('type_id', $type->id) !!}

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Suppliers:</strong>
                                    <br/>
                                    {{ Form::select('supplier_id', $suppliers, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required' => 'required']) }}
                                </div>
                            </div>

                            @foreach($type->attributes as $attribute)
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{$attribute->name}}:</strong>
                                        <br/>
                                        {{ Form::select('id[]', $attribute->hasManyValues->pluck('value', 'id'), null, ['class' => 'form-control', 'placeholder'=>'Select', 'required' => 'required']) }}
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>RRP:</strong>
                                    <br/>
                                    {{ Form::number('price', null, array('class' => 'form-control', 'step' => 'any', 'required' => 'required')) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Cost:</strong>
                                    <br/>
                                    {{ Form::number('cost', 0, array('class' => 'form-control', 'step' => 'any', 'required' => 'required')) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Base:</strong>
                                    <br/>
                                    {{ Form::number('base', 0, array('class' => 'form-control', 'step' => 'any', 'required' => 'required')) }}
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