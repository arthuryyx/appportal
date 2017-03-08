@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">入库</h1>
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
                            <strong>新增失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('tempstock') }}" method="POST">
                        {!! csrf_field() !!}
                        <select name="aid" class="form-control" required="required">
                            <option value="">Select One</option>
                            @foreach($appliances as $id => $model)
                            <option value="{{$id}}">{{$model}}</option>
                            @endforeach
                        </select>
                        <br>
                        {{--<input type="text" name="job" class="form-control" placeholder="job">--}}
                        {{--<br>--}}
                        <input type="text" name="receipt" class="form-control" required="required" placeholder="receipt">
                        <br>
                        <input type="text" name="shelf" class="form-control" placeholder="shelf">
                        <br>
                        <input type="text" name="mount" class="form-control" required="required" placeholder="mount" value="1">
                        <br>
{{--                        <a href="{{ url('tempstock/list/1') }}" class="btn btn-lg btn-danger">Cancel</a>--}}
                        <button class="btn btn-primary pull-right">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection