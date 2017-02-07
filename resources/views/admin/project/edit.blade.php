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
                    <a href="{{ url('admin/project/'.$project->id.'/appliance') }}" class="btn btn-primary">Add Appliances</a>
                </div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>编辑失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/project/'.$project->id) }}" method="POST">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <input type="text" name="customer_id" class="form-control" required="required" placeholder="customer_id" value="{{ $project->customer_id }}">
                        <br>
                        <input type="text" name="job_id" class="form-control" required="required" placeholder="job_id" value="{{ $project->job_id }}">
                        <br>
                        <input type="text" name="address" class="form-control" required="required" placeholder="address" value="{{ $project->address }}">
                        <br>

                        <br>
                        <a href="{{ url('admin/project') }}" class="btn btn-lg btn-danger">Cancel</a>
                        <button class="btn btn-lg btn-success pull-right">Modify</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection