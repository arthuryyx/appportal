@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css')}}" rel="stylesheet">
@endsection

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
                    {!! Form::model($region, ['url' => 'admin/region/'.$region->id, 'method' => 'PATCH']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Status:</strong><br>
                                {{ Form::checkbox('status', null, null, array('id' => 'switch')) }}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>code:</strong>
                                {!! Form::text('code', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>name:</strong>
                                {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) !!}
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

@section('js')
    <script src="{{ asset('vendor/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("#switch")
                .bootstrapSwitch('onColor', 'success')
                .bootstrapSwitch('onText', 'Use')
                .bootstrapSwitch('offColor', 'danger')
                .bootstrapSwitch('offText', 'Discontinue');

            $("#switch").on('switchChange.bootstrapSwitch', function(event, state) {
                if(state){
                    $(".form-control").removeAttr('disabled');
                }else {
                    $(".form-control").attr('disabled', 'disabled');
                }

            });
            $("#switch").bootstrapSwitch('toggleState').bootstrapSwitch('toggleState');

            $('#form').on('submit', function () {
                $(this).find('input[type="submit"], button').attr('disabled', 'disabled');
            });
        });
    </script>
@endsection