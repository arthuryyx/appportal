@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">New Invoice</h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @elseif ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ $message }}
                        </div>
                    @endif

                    {!! Form::open(['url' => 'kitchen/board/stock','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::select('brand', ['Prime' =>'Prime', 'Melteca' =>'Melteca', 'bestwood' =>'bestwood', 'Zealand' =>'Zealand'], null, ['class' => 'form-control', 'placeholder'=>'Brand', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::text('title', '', array('class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required')) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::select('size', ['2440X1220mm'=>'2440X1220mm', '2400X900mm'=>'2400X900mm', '2700x1220mm'=>'2700x1220mm', '3660X1220mm'=>'3660X1220mm', '3600X600mm'=>'3600X600mm'], null, ['class' => 'form-control', 'placeholder'=>'Size', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {{ Form::number('qty', null, array('class' => 'form-control', 'placeholder' => 'Qty', 'required' => 'required')) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <a href="{{ url()->previous()}}" class="btn btn-danger">Cancel</a>
                                {{Form::submit('Submit', ['class' => 'btn btn-success pull-right'])}}
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#form').on('submit', function () {
            $(this).find('input[type="submit"], button').attr('disabled', 'disabled');
        });
    </script>
@endsection