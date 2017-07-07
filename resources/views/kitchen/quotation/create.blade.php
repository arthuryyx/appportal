@extends('layouts.app')

@section('css')
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style>
        /*#locationField, #controls {*/
            /*position: relative;*/
            /*width: 480px;*/
        /*}*/
        /*#autocomplete {*/
            /*position: absolute;*/
            /*top: 0px;*/
            /*left: 0px;*/
            /*width: 99%;*/
        /*}*/
        .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
            color: #303030;
        }
        #address {
            border: 1px solid #000090;
            background-color: #f0f0ff;
            width: 480px;
            padding-right: 2px;
        }
        #address td {
            font-size: 10pt;
        }
        .field {
            width: 99%;
        }
        .slimField {
            width: 80px;
        }
        .wideField {
            width: 200px;
        }
        #locationField {
            height: 20px;
            margin-bottom: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">New Quotation</h2>
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
                    {!! Form::open(['url' => 'kitchen/quot/','method'=>'POST']) !!}
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>first name:</strong>
                                {!! Form::text('first', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>last name:</strong>
                                {!! Form::text('last', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>phone:</strong>
                                {!! Form::number('phone', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>mobile:</strong>
                                {!! Form::number('mobile', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>email:</strong>
                                {!! Form::email('email', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>address:</strong>
                                {{--<div id="locationField">--}}
                                    {{--<input id="autocomplete" class="form-control" placeholder="Enter your address" onFocus="geolocate()" type="text">--}}
                                    {!! Form::text('address', null, array('id' => 'autocomplete', 'class' => 'form-control', 'required' => 'required')) !!}
                                {{--</div>--}}
                            </div>
                        </div>

                        {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                                {{--<strong>street:</strong>--}}
                                {{--{!! Form::text('street', null, array('id' => 'route', 'class' => 'form-control', 'required' => 'required')) !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                                {{--<strong>sub:</strong>--}}
                                {{--{!! Form::text('sub', null, array('id' => 'sublocality_level_1', 'class' => 'form-control', 'required' => 'required')) !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                                {{--<strong>city:</strong>--}}
                                {{--{!! Form::text('city', null, array('id' => 'locality', 'class' => 'form-control', 'required' => 'required')) !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                                {{--<strong>zip:</strong>--}}
                                {{--{!! Form::number('zip', null, array('id' => 'postal_code', 'class' => 'form-control', 'required' => 'required')) !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                                {{--<strong>comment:</strong>--}}
                                {{--{!! Form::textarea('comment', null, array('class' => 'form-control')) !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <a href="{{ url()->previous()}}" class="btn btn-danger">Cancel</a>
                            {{Form::submit('Submit', ['class' => 'btn btn-success pull-right'])}}
                        </div>
                    </div>
                    {!! Form::close() !!}





                    {{--<table id="address">--}}
                        {{--<tr>--}}
                            {{--<td class="label">Street address</td>--}}
                            {{--<td class="slimField"><input class="field" id="street_number"--}}
                                                         {{--disabled="true"></input></td>--}}
                            {{--<td class="wideField" colspan="2"><input class="field" id="route"--}}
                                                                     {{--disabled="true"></input></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td class="label">City</td>--}}
                            {{--<!-- Note: Selection of address components in this example is typical.--}}
                                 {{--You may need to adjust it for the locations relevant to your app. See--}}
                                 {{--https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform--}}
                            {{---->--}}
                            {{--<td class="wideField" colspan="3"><input class="field" id="locality"--}}
                                                                     {{--disabled="true"></input></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td class="label">State</td>--}}
                            {{--<td class="slimField"><input class="field"--}}
                                                         {{--id="administrative_area_level_1" disabled="true"></input></td>--}}
                            {{--<td class="label">Zip code</td>--}}
                            {{--<td class="wideField"><input class="field" id="postal_code"--}}
                                                         {{--disabled="true"></input></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td class="label">Country</td>--}}
                            {{--<td class="wideField" colspan="3"><input class="field"--}}
                                                                     {{--id="country" disabled="true"></input></td>--}}
                        {{--</tr>--}}
                    {{--</table>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        var placeSearch, autocomplete;
//        var componentForm = {
//            street_number: 'short_name',
//            route: 'long_name',
//            sublocality_level_1: 'long_name',
//            locality: 'long_name',
//            administrative_area_level_1: 'short_name',
//            country: 'long_name',
//            postal_code: 'short_name'
//        };

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
//            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace().address_components;

//            for (var component in componentForm) {
//                document.getElementById(component).value = '';
//                document.getElementById(component).disabled = false;
//            }
            var components = {};
            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.length; i++) {
                components[place[i].types[0]] = place[i]['long_name'];
            }
            if(components['sublocality_level_1'] == components['locality']){
                components['locality'] = components['administrative_area_level_1']
            }
            for (var key in components){
                if(document.getElementById(key)){
                    document.getElementById(key).value = components[key];
                }
            }
//            console.log(components);

        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp18TQsetlBBhkDTiVeeCc4K6zOHbZnHY&language=en&region=NZ&libraries=places&callback=initAutocomplete" async defer></script>
@endsection