@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        <form action="{{ url('admin/permission/'.$permission->id) }}" method="POST">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <input type="text" name="name" class="form-control" required="required" placeholder="name" value="{{ $permission->name }}">
                            <input type="text" name="label" class="form-control" required="required" placeholder="label" value="{{ $permission->label }}">
                            <textarea name="description" rows="5" class="form-control" placeholder="Description">{{ $permission->description }}</textarea>
                            <br>
                            <button class="btn btn-lg btn-success pull-right">提交修改</button>
                            <a href="{{ url()->previous()}}" class="btn btn-lg btn-danger">Go back</a>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection