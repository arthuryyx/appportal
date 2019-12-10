@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/select2/select2-bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" style="padding:12px 0px;font-size:25px;"><strong>import export csv or excel file into database</strong></h3>
            </div>
            <div class="panel-body">


                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif


                @if ($message = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! implode('<br>', $errors->all()) !!}
                    </div>
                @endif
                <h3>Import File Form:</h3>
                <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 20px;" action="importExcel" class="form-horizontal" method="post" enctype="multipart/form-data">

                    {{ Form::select('brand_id', $brands, null, ['class' => 'form-control', 'placeholder'=>'', 'required' => 'required']) }}

                    <input type="file" name="import_file" required="required" />
                    {{ csrf_field() }}
                    <br/>


                    <button class="btn btn-primary">Import CSV or Excel File</button>


                </form>
                <br/>


                <h3>Import File From Database:</h3>
                <div style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 20px;">
                    <a href="{{ url('downloadExcel/xls') }}"><button class="btn btn-success btn-lg disabled" disabled="disabled">Download Excel xls</button></a>
                    <a href="{{ url('downloadExcel/xlsx') }}"><button class="btn btn-success btn-lg disabled" disabled="disabled">Download Excel xlsx</button></a>
                    <a href="{{ url('downloadExcel/csv') }}"><button class="btn btn-success btn-lg disabled" disabled="disabled">Download CSV</button></a>
                </div>


            </div>
        </div>
    </div>
@endsection
