@extends(Auth::user() ? 'layouts.auth' : 'layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')

            @include('events.partials.filters')

            <h1 class="text-center white-color title-margin">@lang('messages.events/title')</h1>
            @if (count($events) > 0)
                @foreach(array_chunk($events, 3) as $eventSet)
                    <div class="row">
                        @foreach($eventSet as $event)
                            <div class="col-sm-6 col-md-4">
                                @include('events.partials.event')
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
               <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center panel-title">
                            @lang('messages.events/noEventsTitle')
                        </h3>
                    </div>
                    <div class="text-center panel-body">
                        @lang('messages.events/noEventsText')
                    </div>
                </div>
            @endif
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

