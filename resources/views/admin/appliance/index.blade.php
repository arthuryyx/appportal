@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Appliance Management</h3></div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <a href="{{ url('admin/appliance/create') }}" class="btn btn-lg btn-primary">新增</a>

                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    model
                                </th>
                                <th>
                                    Brand
                                </th>
                                <th>
                                    Category
                                </th>
                                <th>
                                    best
                                </th>
                                <th>
                                    rrp
                                </th>
                                <th>
                                    promotion
                                </th>
                                <th>
                                    cut-out
                                </th>
                                <th>
                                    description
                                </th>
                                <th>

                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($appliances as $appliance)
                                <tr>
                                    <td>{{ $appliance->name }}</td>
                                    <td>{{ $appliance->model }}</td>
                                    <td>{{ $appliance->belongsToBrand->name }}</td>
                                    <td>{{ $appliance->belongsToCategory->name }}</td>
                                    <td>{{ $appliance->best }}</td>
                                    <td>{{ $appliance->rrp }}</td>
                                    <td>{{ $appliance->promotion }}</td>
                                    <td>{{ $appliance->cutout }}</td>
                                    <td>{{ $appliance->description }}</td>
                                    <td><a href="{{ url('admin/appliance/'.$appliance->id.'/edit') }}" class="btn btn-success">编辑</a></td>
                                    <td><form action="{{ url('admin/appliance/'.$appliance->id) }}" method="POST" style="display: inline;">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger">删除</button>
                                        </form>
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