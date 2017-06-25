@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/treeview.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Manage Category TreeView</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Category List</h3>
                        <ul id="tree1" class="tree">
                            @foreach($categories as $category)
                                <li>
                                    {{ $category->name }}
                                    @if(count($category->children))
                                        @include('product.category.manageChild',['children' => $category->children])
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3>Add New Category</h3>

                        {!! Form::open(['route'=>'add.category']) !!}

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Parent Category:</strong>
                                <br/>
                                {{ Form::select('parent_id', [0 =>'Null'] + $allCategories, null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Type:</strong>
                                <br/>
                                {{ Form::select('type', $types, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required' => 'required']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success">Add New</button>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/treeview.js')}}"></script>

    <script type="text/javascript">
        $("select[name='parent_id']").change(function(){
            var parent_id = $(this).val();
            if(parent_id == 0){
                $("select[name='type']").val(null);
                $("select[name='type'] option").siblings().removeAttr('disabled');
            }else {
                $.ajax({
                    url: 'select-ajax',
                    method: 'POST',
                    data: {parent_id:parent_id, _token:$("input[name='_token']").val()},
                    success: function(data) {
                        $("select[name='type']").val(data);
                        $("select[name='type'] option:selected").removeAttr('disabled').siblings().attr('disabled','disabled');
                    },
                    error: function (e) {
                        alert(e);
                    }
                });
            }
        });
    </script>
@endsection