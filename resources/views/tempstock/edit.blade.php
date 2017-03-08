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
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('tempstock/'.$stock->id) }}" method="POST">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        {{--<select name="aid" class="form-control" required="required">--}}
                            {{--<option value="">Select One</option>--}}
                            {{--@foreach($appliances as $id => $model)--}}
                                {{--<option value="{{$id}}" @if($id == $stock->appliance->id) selected="selected" @endif>{{$model}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                        <input type="text" name="aid" class="form-control" disabled="disabled" value="{{ $stock->appliance->model }}">
                        <br>
                        {{--<input type="text" name="job" class="form-control" placeholder="job" value="{{ $stock->assign_to }}">--}}
                        {{--<br>--}}
                        <input type="text" name="receipt" class="form-control" disabled="disabled" value="{{ $stock->receipt }}">
                        <br>
                        <input type="text" name="shelf" class="form-control" placeholder="shelf" value="{{ $stock->shelf }}">
                        <br>

                        <a href="{{ URL::previous() }}" class="btn btn-lg btn-danger">Cancel</a>
                        <button class="btn btn-lg btn-success pull-right">Modify</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection