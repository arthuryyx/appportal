@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Category Management</h3></div>
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
                            {!! Form::open(['url' => 'kitchen/product/category','method'=>'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        {!! Form::text('name', null, array('placeholder' => 'Brand Name','class' => 'form-control', 'required' => 'required')) !!}
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

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($table as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-center"><a href="{{ url('kitchen/product/category/'.$category->id.'/edit') }}" class="btn btn-success">编辑</a></td>
                                    {{--<td>--}}
                                        {{--<!-- Button trigger modal -->--}}
                                        {{--<button class="btn btn-danger center-block" data-toggle="modal" data-target={{"#myModal".$role->id}}>--}}
                                            {{--删除--}}
                                        {{--</button>--}}
                                        {{--<!-- Modal -->--}}
                                        {{--<div class="modal fade" id={{"myModal".$role->id}} tabindex="-1" role="dialog">--}}
                                            {{--<div class="modal-dialog">--}}
                                                {{--<div class="modal-content">--}}
                                                    {{--<div class="modal-header">--}}
                                                        {{--<button type="button" class="close" data-dismiss="modal" >&times;</button>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="modal-body">--}}
                                                        {{--{{$role->name}}--}}
                                                    {{--</div>--}}
                                                    {{--<div class="modal-footer">--}}
                                                        {{--<form action="{{ url('admin/role/'.$role->id) }}" method="POST" style="display: inline;">--}}
                                                            {{--{{ method_field('DELETE') }}--}}
                                                            {{--{{ csrf_field() }}--}}
                                                            {{--<button type="submit" class="btn btn-danger">删除</button>--}}
                                                            {{--<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>--}}
                                                        {{--</form>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<!-- /.modal-content -->--}}
                                            {{--</div>--}}
                                            {{--<!-- /.modal-dialog -->--}}
                                        {{--</div>--}}
                                        {{--<!-- /.modal -->--}}
                                    {{--</td>--}}
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