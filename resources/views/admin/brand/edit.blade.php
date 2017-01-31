@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑文章</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>编辑失败</strong> 输入不符合要求<br><br>
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        <form action="{{ url('admin/brand/'.$brand->id) }}" method="POST">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <input type="text" name="name" class="form-control" required="required" placeholder="请输入标题" value="{{ $brand->name }}">
                            <input type="hidden" name="type" required="required" value="{{$brand->type}}">
                            {{--<select name="group_id" class="form-control" required="required">
                                @foreach($groups as $id => $name)
                                    <option value="{{$id}}" @if($id == $brand->belongsToGroup->id) selected='selected' @endif >{{$name}}</option>
                                @endforeach
                            </select>--}}

                            <br>
                            <button class="btn btn-lg btn-info">提交修改</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection