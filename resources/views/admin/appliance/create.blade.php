@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add an Appliance</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ url('admin/brand/appliance') }}" class="btn btn-primary">Manage Brand</a>
                    <a href="{{ url('admin/category/appliance') }}" class="btn btn-primary">Manage Category</a>
                </div>
                <!-- /.panel-heading -->
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
                    {!! Form::open(['url' => 'admin/appliance','method'=>'POST', 'id'=>'form']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>model:</strong>
                                    {!! Form::text('model', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>brand:</strong>
                                    {{ Form::select('brand_id', $brands, null, ['class' => 'form-control', 'placeholder'=>'', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>category:</strong>
                                    {{ Form::select('category_id', $categories, null, ['class' => 'form-control', 'placeholder'=>'', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>rrp:</strong>
                                    {!! Form::number('rrp', null, array('class' => 'form-control', 'step' => 'any', 'min' => '0')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>rsp:</strong>
                                    {!! Form::number('lv1', null, array('class' => 'form-control', 'step' => 'any', 'min' => '0')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>lv2 price:</strong>
                                    {!! Form::number('lv2', null, array('class' => 'form-control', 'step' => 'any', 'min' => '0')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>lv3 price:</strong>
                                    {!! Form::number('lv3', null, array('class' => 'form-control', 'step' => 'any', 'min' => '0')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>cost price:</strong>
                                    {!! Form::number('lv4', null, array('class' => 'form-control', 'step' => 'any', 'min' => '0')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>description:</strong>
                                    {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
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
    <script>
        $('#form').on('submit', function () {
            $(this).find('input[type="submit"], button').attr('disabled', 'disabled');
        });
    </script>
@endsection