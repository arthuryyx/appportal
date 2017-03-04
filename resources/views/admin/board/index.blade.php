@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Account Management</h3></div>
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
                            {!! Form::open(['url' => 'admin/account','method'=>'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>password:</strong>
                                        {!! Form::password('password', array('placeholder' => 'password','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>password_confirmation:</strong>
                                        {!! Form::password('password_confirmation', array('placeholder' => 'password_confirmation','class' => 'form-control', 'required' => 'required')) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>State:</strong>
                                        <br/>
                                        <label>{!! Form::radio('active', 1, array('class' => 'form-control checkbox-inline')) !!}
                                            Active
                                        </label>
                                        <label>{!! Form::radio('active', 0, array('class' => 'form-control checkbox-inline')) !!}
                                            Deactive
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Permission:</strong>
                                        <br/>
                                        @foreach($roles as $id => $label)
                                            <label>{{ Form::checkbox('roles[]', $id, false, array('class' => 'name checkbox-inline')) }}
                                                {{ $label }}
                                            </label>
                                            &nbsp;
                                        @endforeach
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
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Active
                                </th>
                                <th>
                                    Roles
                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->active)
                                            <button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($user->roles))
                                            @foreach($user->roles as $v)
                                                <label class="label label-info">{{ $v->label }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-center"><a href="{{ url('admin/account/'.$user->id.'/edit') }}" class="btn btn-success">编辑</a></td>
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