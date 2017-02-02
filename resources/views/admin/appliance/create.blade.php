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
                        <div class="alert alert-danger">
                            <strong>新增失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/appliance') }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="text" name="name" class="form-control" placeholder="name">
                        <br>
                        <input type="text" name="model" class="form-control" required="required" placeholder="model">
                        <br>
                        <select name="brand_id" class="form-control" required="required">
                            <option value="">Select One</option>
                            @foreach($brands as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <select name="category_id" class="form-control" required="required">
                            <option value="">Select One</option>
                            @foreach($categories as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <input type="text" name="cutout" class="form-control" placeholder="Cut-out">
                        <br>
                        <input type="text" name="best" class="form-control" placeholder="Best Price">
                        <br>
                        <input type="text" name="rrp" class="form-control" placeholder="RRP">
                        <br>
                        <input type="text" name="promotion" class="form-control" placeholder="Promotion">
                        <br>
                        <textarea name="description" rows="5" class="form-control" placeholder="Description"></textarea>
                        <br>
                        <a href="{{ url('admin/appliance') }}" class="btn btn-lg btn-danger">Cancel</a>
                        <button class="btn btn-lg btn-success pull-right">Create</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection