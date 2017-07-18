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
                            <strong>编辑失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                        {!! Form::model($product, ['id' =>'partForm', 'url' => 'product/model/'.$product->id,'method'=>'PUT']) !!}
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Model:</strong>
                                    {!! Form::text('model', null, array('class' => 'form-control', 'required' => 'required')) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Category:</strong>
                                    <br/>
                                    {{ Form::select('category_id', $categories, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required' => 'required' ]) }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Parts:</strong>
                                    <br/>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            {{ Form::select('part[0][id]', $parts, null, ['class' => 'form-control', 'placeholder' => 'select part', 'required' => 'required']) }}
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::number('part[0][qty]', null, array('class' => 'form-control', 'placeholder' => 'qty')) !!}
                                        </div>
                                        <div class="col-xs-1">
                                            <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- The template for adding new field -->
                            <div class="col-xs-12 col-sm-12 col-md-12 form-group hide" id="partTemplate">
                                <div class="row">
                                    <div class="col-xs-4">
                                        {{ Form::select('id', $parts, null, ['class' => 'form-control', 'placeholder' => 'select part']) }}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::number('qty', null, array('class' => 'form-control', 'placeholder' => 'qty')) !!}
                                    </div>
                                    <div class="col-xs-1">
                                        <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                    </div>
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
        $(document).ready(function() {
//            var titleValidators = {
//                    row: '.col-xs-4',   // The title is placed inside a <div class="col-xs-4"> element
//                    validators: {
//                        notEmpty: {
//                            message: 'The title is required'
//                        }
//                    }
//                },
//                isbnValidators = {
//                    row: '.col-xs-4',
//                    validators: {
//                        notEmpty: {
//                            message: 'The ISBN is required'
//                        },
//                        isbn: {
//                            message: 'The ISBN is not valid'
//                        }
//                    }
//                },
//                priceValidators = {
//                    row: '.col-xs-2',
//                    validators: {
//                        notEmpty: {
//                            message: 'The price is required'
//                        },
//                        numeric: {
//                            message: 'The price must be a numeric number'
//                        }
//                    }
//                },
            partIndex = 0;

            $('#partForm')
            //                .formValidation({
            //                    framework: 'bootstrap',
            //                    icon: {
            //                        valid: 'glyphicon glyphicon-ok',
            //                        invalid: 'glyphicon glyphicon-remove',
            //                        validating: 'glyphicon glyphicon-refresh'
            //                    },
            //                    fields: {
            //                        'part[0].title': titleValidators,
            //                        'part[0].isbn': isbnValidators,
            //                        'part[0].price': priceValidators
            //                    }
            //                })

            // Add button click handler
                .on('click', '.addButton', function() {
                    partIndex++;
                    var $template = $('#partTemplate'),
                        $clone    = $template
                            .clone()
                            .removeClass('hide')
                            .removeAttr('id')
                            .attr('data-part-index', partIndex)
                            .insertBefore($template);

                    // Update the name attributes
                    $clone
                        .find('[name="id"]').attr('name', 'part[' + partIndex + '][id]').attr('required', 'required').end()
                        .find('[name="qty"]').attr('name', 'part[' + partIndex + '][qty]').end();

                    // Add new fields
                    // Note that we also pass the validator rules for new field as the third parameter
//                    $('#partForm')
//                        .formValidation('addField', 'part[' + partIndex + '].title', titleValidators)
//                        .formValidation('addField', 'part[' + partIndex + '].isbn', isbnValidators)
//                        .formValidation('addField', 'part[' + partIndex + '].price', priceValidators);
                })

                // Remove button click handler
                .on('click', '.removeButton', function() {
                    var $row  = $(this).parents('.form-group'),
                        index = $row.attr('data-part-index');

                    // Remove fields
                    $('#partForm')
//                        .formValidation('removeField', $row.find('[name="part[' + index + '].title"]'))
//                        .formValidation('removeField', $row.find('[name="part[' + index + '].isbn"]'))
//                        .formValidation('removeField', $row.find('[name="part[' + index + '].price"]'));

                    // Remove element containing the fields
                    $row.remove();
                });

            $('#partForm').on('submit', function(e){
                $('#partTemplate').remove();
            });
        });
    </script>
@endsection