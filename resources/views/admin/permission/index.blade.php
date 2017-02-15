@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Permission Management</h3></div>
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
                        <form action="{{ url('admin/permission') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="text" name="name" class="form-control" required="required" placeholder="name">
                            <input type="text" name="label" class="form-control" required="required" placeholder="label">
                            <textarea name="description" rows="5" class="form-control" placeholder="Description"></textarea>
                            <button class="btn btn-primary">新增</button>
                        </form>
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
                                    Label
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>

                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->label }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td><a href="{{ url('admin/permission/'.$permission->id.'/edit') }}" class="btn btn-success">编辑</a></td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button class="btn btn-danger" data-toggle="modal" data-target={{"#myModal".$permission->id}}>
                                            删除
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id={{"myModal".$permission->id}} tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{$permission->name}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('admin/permission/'.$permission->id) }}" method="POST" style="display: inline;">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection