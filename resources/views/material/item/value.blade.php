@extends('layouts.app')

@section('css')
    <link rel="{{ asset('vendor/jquery-ui/jquery-ui.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Set Attribute Value</h2>
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
                        {!! Form::open(['url' => 'material/item','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Model:</strong>
                                    {!! Form::text(null, $model, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                                    {!! Form::hidden('model', $model) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Suppliers:</strong>
                                    <br/>
                                    {{ Form::select('supplier_id', [null=>'Please Select'] + $suppliers, null, ['class' => 'form-control', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div id="sortable">
                                @foreach($data as $obj)
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>{{$obj['name']}}:</strong>
                                            <br/>
                                            {{ Form::select('id[]', [null=>'Please Select'] + $obj['values'], null, ['class' => 'form-control', 'required' => 'required']) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {{Form::submit('Submit', ['class' => 'btn btn-success pull-right'])}}
                                {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>

    <script>
        $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        } );
    </script>
@endsection