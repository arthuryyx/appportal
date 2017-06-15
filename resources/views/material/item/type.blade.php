@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">New Attribute</h2>
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
                        {!! Form::open(['url' => 'material/item/create/value','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Model:</strong>
                                    {!! Form::text('model', null, array('placeholder' => 'Model','class' => 'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Attributes:</strong>
                                    <br/>
                                    @foreach($types as $id => $name)
                                        <label>{{ Form::checkbox('types[]', $id, false, array('class' => 'name checkbox-inline')) }}
                                            {{ $name }}
                                        </label>
                                        &nbsp;
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {{Form::submit('Submit', ['class' => 'btn btn-success pull-right'])}}
                                {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection