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

                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('appliance/stock/'.$sid.'/price') }}" method="POST">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}

                        <input type="number" name="price" placeholder="Price" class="form-control" step="any" required = "required">
                        <br>
			            <input type="number" name="warranty" placeholder="Warranty" class="form-control">
                        <br>
                        <a href="{{ URL::previous() }}" class="btn btn-lg btn-danger">Cancel</a>
                        <button class="btn btn-lg btn-success pull-right">Modify</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection