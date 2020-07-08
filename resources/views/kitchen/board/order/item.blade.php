@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $item->getStock->brand.' '.$item->getStock->title.' | '.$item->remain.' Sheet(s)' }}</h1>
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

                        {!! Form::open( ['url' => 'kitchen/board/order/item/'.$item->id, 'method' => 'POST']) !!}
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>取消数量:</strong>
                                    {!! Form::number('qty', $item->remain, array('class' => 'form-control', 'step' => 'any', 'min' => '1', 'max' => $item->remain )) !!}
                                </div>
                            </div>



                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>备注:</strong>
                                    {!! Form::text('remark', null, array('class' => 'form-control')) !!}
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