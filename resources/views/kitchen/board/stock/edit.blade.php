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

                        {!! Form::model($stock, ['method' => 'PATCH','route' => ['board.stock.update', $stock->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::text('brand', null, ['class' => 'form-control', 'placeholder'=>'Brand', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required')) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::text('size', null, ['class' => 'form-control', 'placeholder'=>'Size', 'required' => 'required']) }}
                                </div>
                            </div>

                            @can('root')
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::number('qty', null, array('class' => 'form-control', 'placeholder' => 'Qty', 'required' => 'required')) }}
                                </div>
                            </div>
                            @endcan

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