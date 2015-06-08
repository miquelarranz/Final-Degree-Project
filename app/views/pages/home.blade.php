@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="text-align: center; margin-bottom: 30px;">
            <img src="/images/logo2.png" style="width: 95%; max-width: 300px; max-height: 300px; margin: 0 auto;" class="img-responsive"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ Form::open(array('route' => 'filter_path')) }}
                <div class="row">
                    <div class = "form-group col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
                        {{ Form::select('city', array(null => Lang::get('messages.filters/cityempty')) + $cities, null, ['id' => 'cities', 'class' => 'form-control', 'required' => 'required']) }}
                    </div>
                </div>
                <div class="row">
                    <div class = "col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
                        <h4 class="home-title-search text-center">@lang('messages.home/searchtext')</h4>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="home-search glyphicon glyphicon-search" aria-hidden="true"></span>
                            </span>
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => Lang::get('messages.filters/name')] ) }}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default home-button" type="button">@lang("messages.home/search")</button>
                            </span>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="row">
        <div class = "col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
            <p class="text-center home-users-guide-text">
                {{ link_to_route('manual_path', Lang::get("messages.home/guide")) }}
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <!--<script src="/scripts/map.js"></script>-->
    <script>
        var map;
        var pos;

        var mapOptions = {
            zoom: 14
        };

        window.onload = function()
        {

            if(navigator.geolocation)
            {
                navigator.geolocation.getCurrentPosition(function(position)
                {
                    pos = new google.maps.LatLng(position.coords.latitude,
                        position.coords.longitude);
                    var itemLocality = '';
                    geocoder = new google.maps.Geocoder();
                    geocoder.geocode( { 'latLng': pos}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            $.each(results, function(i, address_component) {
                                if (address_component.types[0] == "locality") {
                                    itemLocality = address_component.address_components[0].long_name;
                                }
                            });

                            $.ajax({
                                type: "POST",
                                url: "{{ URL::route('geolocate_path') }}",
                                data: { city: itemLocality }
                            }).done(function( exists ) {
                                if (exists.data != -1)
                                {
                                    $('#cities').val(exists.data);
                                }
                            });
                        }
                    });
                });
            }
        }
    </script>
@endsection



