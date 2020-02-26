@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Regions</h3></div>
                <div class="panel-body">
                    <div class="container-fluid">
                        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Add New
                        </a>
                    </div>
                    @if (count($errors) > 0)
                        <br>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <div class="collapse" id="collapseExample">
                        <div class="container-fluid">
                            {!! Form::open(['url' => 'admin/region','method'=>'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Form::text('code', null, array('placeholder' => 'Region code','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                    <div class="form-group">
                                            {!! Form::text('name', null, array('placeholder' => 'Region Name','class' => 'form-control', 'required' => 'required')) !!}
                                        </div>
                                    </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
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
                                    Code
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($regions as $region)
                                <tr>
                                    <td>{{ $region->code }}</td>
                                    <td>{{ $region->name }}</td>
                                    <td>
                                        @if($region->status)
                                            <button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
                                        @endif
                                    </td>
                                    <td><a href="{{ url('admin/region/'.$region->id.'/edit') }}" class="btn btn-success">编辑</a></td>
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