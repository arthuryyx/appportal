@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">New Material Type</h2>
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
                    {!! Form::open(['url' => 'material/type','method'=>'POST']) !!}
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Attributes:</strong>
                                {{ Form::select('types[]', $types, null, ['class' => 'form-control', 'multiple'=>'multiple', 'placeholder'=>'Select', 'required' => 'required']) }}

                                {{--<br/>--}}
                                {{--@foreach($types as $id => $name)--}}
                                    {{--<label>{{ Form::checkbox('types[]', $id, false, array('class' => 'name checkbox-inline')) }}--}}
                                        {{--{{ $name }}--}}
                                    {{--</label>--}}
                                    {{--&nbsp;--}}
                                {{--@endforeach--}}
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