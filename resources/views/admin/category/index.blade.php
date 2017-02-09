@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Category Management</h3></div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    {{--<a href="{{ url('admin/article/create') }}" class="btn btn-lg btn-primary">新增</a>--}}
                    <div class="panel panel-default">
                        <div class="panel-heading">Add a Category</div>
                        <div class="panel-body">
                            <form action="{{ url('admin/category') }}" method="POST">
                                {!! csrf_field() !!}
                                <input type="text" name="name" class="form-control" required="required" placeholder="请输入标题">
                                <input type="hidden" name="type" required="required" value="{{$type}}">
                                {{--<select name="group_id" class="form-control" required="required">
                                    <option value="">Select One</option>
                                    @foreach($groups as $id => $name)
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>--}}
                                <button class="btn btn-lg btn-info">新增</button>
                            </form>

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
                                    Type
                                </th>
                                <th>

                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->type }}</td>
                                    <td><a href="{{ url('admin/category/'.$category->id.'/edit') }}" class="btn btn-success">编辑</a></td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button class="btn btn-danger" data-toggle="modal" data-target={{"#myModal".$category->id}}>
                                            删除
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id={{"myModal".$category->id}} tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{$category->name}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('admin/category/'.$category->id) }}" method="POST" style="display: inline;">
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
                                        <!-- /.modal -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{ url('admin/'.$type.'/create') }}" class="btn btn-lg btn-primary">Go back</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection