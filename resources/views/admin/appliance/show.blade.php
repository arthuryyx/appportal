@extends('layouts.app')

@section('css')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/select2/select2-bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <strong>model:</strong>
                    {{ Form::select('aid', [], null, ['class' => 'form-control', 'required' => 'required']) }}
                    <hr>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/select2/select2.min.js')}}"></script>
    <script type="text/javascript">
        $('[name="aid"]').select2({
            theme: "bootstrap",
            ajax: {
                url: '/select2-autocomplete-ajax/applianceModel',
                dataType: 'json',
                delay: 500,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.model,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        })
        .on('select2:select', function (e) {
            $.ajax({
                url: '/admin/appliance/' + e.params.data.id,
                method: 'GET',
                success: function(data) {
                    $('#dataTables').html('');
                    $('#dataTables').html(data);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        });
    </script>
@endsection