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
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @elseif ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ $message }}
                        </div>
                    @endif
                    {!! Form::model($item, ['method' => 'PATCH', 'url' => 'appliance/item/'.$item->id]) !!}
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10">
                            <strong>Amount</strong>
                            {{ Form::number('price', null, array('class' => 'form-control', 'step' => 'any')) }}
                            <strong>Warranty</strong>
                            {{ Form::number('warranty', null, array('class' => 'form-control')) }}
                        </br>{{ Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection