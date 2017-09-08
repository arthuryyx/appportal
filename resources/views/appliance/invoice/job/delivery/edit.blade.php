@extends('layouts.app')

{{--@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection--}}

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

                        {{--{!! Form::model($dispatch, ['method' => 'PATCH','route' => ['job.update', $invoice->id]]) !!}--}}
                        {!! Form::model($dispatch, ['method'=>'PUT', 'url' => 'appliance/delivery/request/'.$dispatch->id]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date</strong>
                                    <input type="datetime-local" name="date" class="form-control">
                                    {{--{!! Form::datetime('date', null, array('id' => 'datepicker', 'class' => 'form-control')) !!}--}}
                                </div>
                            </div>

                            @can('modify_final_price')
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>shipping fee:</strong>
                                    {!! Form::number('fee', null, array('class' => 'form-control', 'step' => 'any', 'min' => '0', 'required' => 'required')) !!}
                                </div>
                            </div>
                            @endcan

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

{{--@section('js')
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>
@endsection--}}
