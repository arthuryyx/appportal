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

                        {!! Form::model($type, ['method' => 'PATCH','route' => ['type.update', $type->id]]) !!}
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>name:</strong>
                                    {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Material Type:</strong>
                                    {{ Form::select('types[]', $types, $selected, ['class' => 'form-control', 'multiple'=>'multiple', 'placeholder'=>'Select', 'required' => 'required']) }}

                                    {{--<br/>--}}
                                    {{--@foreach($types as $id => $name)--}}
                                        {{--<label>{{ Form::checkbox('types[]', $id, in_array($id, $checks) ? true : false, array('class' => 'checkbox-inline')) }}--}}
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