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
                <div class="panel-heading">

                </div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>编辑失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/appliance/'.$appliance->id) }}" method="POST">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <input type="text" name="name" class="form-control" placeholder="name" value="{{ $appliance->name }}">
                        <br>
                        <input type="text" name="model" class="form-control" required="required" placeholder="model" value="{{ $appliance->model }}">
                        <br>
                        <select name="brand_id" class="form-control" required="required">
                            @foreach($brands as $id => $name)
                                <option value="{{$id}}" @if($id == $appliance->belongsToBrand->id) selected='selected' @endif >{{$name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <select name="category_id" class="form-control" required="required">
                            @foreach($categories as $id => $name)
                                <option value="{{$id}}" @if($id == $appliance->belongsToCategory->id) selected='selected' @endif>{{$name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <input type="text" name="cutout" class="form-control" placeholder="Cut-out" value="{{ $appliance->cutout }}">
                        <br>
                        <input type="text" name="best" class="form-control" placeholder="Best Price" value="{{ $appliance->best }}">
                        <br>
                        <input type="text" name="rrp" class="form-control" placeholder="RRP" value="{{ $appliance->rrp }}">
                        <br>
                        <input type="text" name="promotion" class="form-control" placeholder="Promotion" value="{{ $appliance->promotion }}">
                        <br>
                        <textarea name="description" rows="5" class="form-control" placeholder="Description">{{ $appliance->description }}</textarea>
                        <br>

                        <br>
                        <a href="{{ url('admin/appliance') }}" class="btn btn-lg btn-danger">Cancel</a>
                        <button class="btn btn-lg btn-success pull-right">Modify</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection