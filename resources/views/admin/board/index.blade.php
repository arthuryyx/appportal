@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Board Management</h3></div>
                <div class="panel-body">

                    <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Add New
                    </a>
                    @if (count($errors) > 0)
                        <br>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif
                    <div class="collapse" id="collapseExample">
                        <div class="container-fluid">
                            {!! Form::open(['url' => 'admin/material/board','method'=>'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Thickness:</strong>
                                        {!! Form::text('thickness', null, array('placeholder' => 'Thickness','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Brand:</strong>
                                        {!! Form::text('brand', null, array('placeholder' => 'Brand','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Color:</strong>
                                        {!! Form::text('color', null, array('placeholder' => 'Color','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Finish:</strong>
                                        {!! Form::text('finish', null, array('placeholder' => 'Finish','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Making:</strong>
                                        {!! Form::text('making', null, array('placeholder' => 'Making','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Type:</strong>
                                        <br/>
                                        <label>{!! Form::radio('type', 1, array('class' => 'form-control checkbox-inline')) !!}
                                            Panel
                                        </label>
                                        <label>{!! Form::radio('type', 0, array('class' => 'form-control checkbox-inline')) !!}
                                            内柜板
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                    {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Thickness
                                </th>
                                <th>
                                    Brand
                                </th>
                                <th>
                                    Color
                                </th>
                                <th>
                                    Finish
                                </th>
                                <th>
                                    Making
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($boards as $board)
                                <tr>
                                    <td>{{ $board->thickness }}</td>
                                    <td>{{ $board->brand }}</td>
                                    <td>{{ $board->color }}</td>
                                    <td>{{ $board->finish }}</td>
                                    <td>{{ $board->making }}</td>
                                    <td>
                                        @if($board->type == 1)
                                            Panel
                                        @elseif($board->type == 0)
                                            内柜板
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" data-toggle="modal" data-target={{"#myModal".$board->id}}>
                                            删除
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id={{"myModal".$board->id}} tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>{{ $board->name }}</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('admin/material/board/'.$board->id) }}" method="POST" style="display: inline;">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger">删除</button>
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection