@extends(Auth::user() ? 'layouts.auth' : 'layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')

            <div class="thumbnail event-container">
                @if (is_null($event->thing->image))
                    <img class="img-responsive img-thumbnail event-image" src="/images/images-background.jpeg" alt="Event">
                @else
                    <img class="img-responsive img-thumbnail event-image" src="{{ $event->thing->image }}" alt="Event">
                @endif
                <div class="caption">
                    <h3 class="text-center event-title" title="{{ utf8_decode($event->thing->name) }}"> {{ utf8_decode($event->thing->name) }} </h3>
                    @if ( ! is_null($event->startDate))
                        <p class="text-center"><b> {{ $event->startDate }} @if ( ! is_null($event->endDate)) - {{ $event->endDate }} @endif</b></p>
                    @else
                        <p class="text-center event-permanent"><b> @lang('messages.event/date') </b></p>
                    @endif
                    <p class="text-center event-type" title="{{ utf8_decode($event->type) }}"> {{ utf8_decode($event->type) }}</p>

                    <div class="container-fluid">
                        <div class="row text-centered">
                            <div class="event-container col-md-6">
                                @if ( ! is_null($event->thing->description))
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/description')
                                        </div>
                                        <div class="col-xs-12">
                                            {{ utf8_decode($event->thing->description) }}
                                        </div>
                                    </div>
                                @endif
                                @if ( ! is_null($event->thing->url))
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/url')
                                        </div>
                                        <div class="col-xs-12">
                                            <a href="{{ $event->thing->url }}" target="_blank">{{ $event->thing->url }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if (count($event->performers) > 0)
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/performers')
                                        </div>
                                        @foreach($event->performers as $performer)
                                            <div class="col-xs-12">
                                                {{ utf8_decode($performer->thing->name) }} @if( ! is_null($performer->email) and $currentUser) <a href="{{ URL::route('communicate_path', array('id' => $performer->id)) }}"><span class="glyphicon glyphicon-envelope performer-icon" aria-hidden="true"></span></a> @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @if (count($event->offers) > 0)
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/offers')
                                        </div>
                                        @foreach($event->offers as $offer)
                                            @if( ! is_null($offer->price))
                                                <div class="col-xs-12">
                                                    {{ $offer->price }} @if( ! is_null($offer->priceCurrency)) $offer->priceCurrency @else $ @endif
                                                </div>
                                            @else
                                                <p>@lang('messages.event/unavailable')</p>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                @if ( ! is_null($event->eventLocation))
                                    @if ( ! is_null($event->eventLocation->thing->name))
                                        <div class="row text-centered">
                                            <div class="col-xs-12">
                                                @lang('messages.event/city')
                                            </div>
                                            <div class="col-xs-12">
                                                {{ utf8_decode($event->eventLocation->thing->name) }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ( ! is_null($event->eventLocation->postalAddress))
                                        @if ( ! is_null($event->eventLocation->postalAddress->streetAddress))
                                            <div class="row text-centered">
                                                <div class="col-xs-12">
                                                    @lang('messages.event/streetAddress')
                                                </div>
                                                <div class="col-xs-12">
                                                    {{ utf8_decode($event->eventLocation->postalAddress->streetAddress) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ( ! is_null($event->eventLocation->postalAddress->addressRegion))
                                            <div class="row text-centered">
                                                <div class="col-xs-12">
                                                    @lang('messages.event/addressRegion')
                                                </div>
                                                <div class="col-xs-12">
                                                    {{ utf8_decode($event->eventLocation->postalAddress->addressRegion) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ( ! is_null($event->eventLocation->postalAddress->postalCode))
                                            <div class="row text-centered">
                                                <div class="col-xs-12">
                                                    @lang('messages.event/postalCode')
                                                </div>
                                                <div class="col-xs-12">
                                                    {{ utf8_decode($event->eventLocation->postalAddress->postalCode) }}
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                @if ( ! is_null($event->duration))
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/duration')
                                        </div>
                                        <div class="col-xs-12">
                                            {{ $event->duration }}
                                        </div>
                                    </div>
                                @endif
                                @if ( ! is_null($event->status))
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/status')
                                        </div>
                                        <div class="col-xs-12">
                                            {{ $event->status->name }}
                                        </div>
                                    </div>
                                @endif
                                @if ( ! is_null($event->typicalAgeRange))
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/typicalAgeRange')
                                        </div>
                                        <div class="col-xs-12">
                                            {{ utf8_decode($event->typicalAgeRange) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($currentUser)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 data-toggle="collapse" class="text-center panel-title" href="#calendar" aria-expanded="true" aria-controls="collapseOne">
                                                <a class="filters-title">
                                                    @lang('messages.event/calendar')
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="panel-collapse collapse event-google-button" id="calendar">
                                            <div class="panel-body">
                                                <div class = "text-center">
                                                    <a href="{{ URL::route('google_login_path') }}" class="btn btn-default form-control event-add-button">@lang('messages.event/calendar')</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="panel panel-default">
                                    <div class="panel-heading" onclick="resize()">
                                        <h3 data-toggle="collapse" class="text-center panel-title" href="#location" aria-expanded="true" aria-controls="collapseOne">
                                            <a class="filters-title">
                                                @lang('messages.event/location')
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="location">
                                        <div class="panel-body">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 data-toggle="collapse" class="text-center panel-title" href="#similar" aria-expanded="true" aria-controls="collapseOne">
                                            <a class="filters-title">
                                                @lang('messages.event/similar')
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="similar">
                                        <div class="panel-body">
                                            @if (count($similarEvents) > 0)
                                                @foreach ($similarEvents as $similarEvent)
                                                    <a href="{{ URL::route('event_path', array('id' => $similarEvent->id)) }}">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <h4><b>{{ utf8_decode($similarEvent->thing->name) }}</b></h4>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            @else
                                                @lang('messages.event/noSimilarText')
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($currentUser)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 data-toggle="collapse" class="text-center panel-title" href="#download" aria-expanded="true" aria-controls="collapseOne">
                                                <a class="filters-title">
                                                    @lang('messages.event/download')
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="panel-collapse collapse" id="download">
                                            <div class="panel-body">
                                                <div class = "text-center">
                                                    <a href="{{ URL::route('event_download_path', array('id' => $event->id)) }}" class="btn btn-success form-control event-download-button">@lang('messages.event/download')</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($currentUser)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 data-toggle="collapse" class="text-center panel-title" href="#subscribe" aria-expanded="true" aria-controls="collapseOne">
                                                <a class="filters-title">
                                                    @lang('messages.event/subscribe')
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="panel-collapse collapse" id="subscribe">
                                            <div class="panel-body">
                                                <div class = "text-center">
                                                    @if ($subscribed)
                                                        <a href="{{ URL::route('event_subscriptions_path') }}" class="btn btn-warning form-control event-download-button">@lang('messages.event/subscriptions')</a>
                                                    @else
                                                        <a href="{{ URL::route('event_subscription_path', array('id' => $event->id)) }}" class="btn btn-primary form-control event-download-button">@lang('messages.event/subscribe')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($currentUser)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 data-toggle="collapse" class="text-center panel-title" href="#share" aria-expanded="true" aria-controls="collapseOne">
                                                <a class="filters-title">
                                                    @lang('messages.event/share')
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="panel-collapse collapse" id="share">
                                            <div class="panel-body">
                                                <div class="g-plus" data-action="share" data-annotation="none" data-width="55" data-align="center"></div>                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!--<script src="/scripts/map.js"></script>-->
    <script>
        var map;
        var pos;
        var directionsService = new google.maps.DirectionsService();

        function resize() {
            var mapOptions = {
                zoom: 14
            };
            map = new google.maps.Map(document.getElementById('map'),
                mapOptions);

            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    pos = new google.maps.LatLng(position.coords.latitude,
                        position.coords.longitude);

                    var marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                    });

                    google.maps.event.trigger(window.map, 'resize');

                    @if ( ! is_null($event->location))
                        @if ( ! is_null($event->eventLocation->geo))
                            @if ( ! is_null($event->eventLocation->geo) and ! is_null($event->eventLocation->geoCoordinates->latitude) and ! is_null($event->eventLocation->geoCoordinates->longitude))
                                var latlng = new google.maps.LatLng( {{ $event->eventLocation->geoCoordinates->latitude }}, {{ $event->eventLocation->geoCoordinates->longitude }});
                                geocoder = new google.maps.Geocoder();
                                geocoder.geocode( { 'latLng': latlng}, function(results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        var marker = new google.maps.Marker({
                                            map: map,
                                            position: results[0].geometry.location
                                        });
                                        directionsDisplay = new google.maps.DirectionsRenderer();
                                        var request = {
                                            origin: pos,
                                            destination: results[0].geometry.location,
                                            travelMode: google.maps.TravelMode.DRIVING
                                        };
                                        directionsService.route(request, function(response, status) {
                                            if (status == google.maps.DirectionsStatus.OK) {
                                                directionsDisplay.setMap(map);
                                                directionsDisplay.setDirections(response);
                                            }
                                        });
                                    } else {
                                        alert('Geocode was not successful for the following reason: ' + status);
                                    }
                                });
                            @endif
                        @else
                            @if ( ! is_null($event->eventLocation->address))
                                var address = "";

                                address = address + ", " + "{{ utf8_decode($event->eventLocation->postalAddress->streetAddress) }}";

                                address = address + ", " + "{{ utf8_decode($event->eventLocation->postalAddress->addressRegion) }}";

                                address = address + ", " + "{{ utf8_decode($event->eventLocation->postalAddress->postalCode) }}";

                                address = address + ", " + "{{ utf8_decode($event->eventLocation->thing->name) }}";

                                geocoder = new google.maps.Geocoder();
                                geocoder.geocode( { 'address': address}, function(results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        var marker = new google.maps.Marker({
                                            map: map,
                                            position: results[0].geometry.location
                                        });
                                        directionsDisplay = new google.maps.DirectionsRenderer();
                                        var request = {
                                            origin: pos,
                                            destination: results[0].geometry.location,
                                            travelMode: google.maps.TravelMode.DRIVING
                                        };
                                        directionsService.route(request, function(response, status) {
                                            if (status == google.maps.DirectionsStatus.OK) {
                                                directionsDisplay.setMap(map);
                                                directionsDisplay.setDirections(response);
                                            }
                                        });
                                    } else {
                                        alert('Geocode was not successful for the following reason: ' + status);
                                    }
                                });
                            @endif
                        @endif
                    @endif

                }, function() {
                    handleNoGeolocation(true);
                });
            } else {
                handleNoGeolocation(false);
            }
        }

        function handleNoGeolocation(errorFlag) {
            var div = document.getElementById('map');

            if (errorFlag) {
                var content = 'Error: The Geolocation service failed.';
                div.html('<p>' + content + '</p>')
            } else {
                var content = 'Error: Your browser doesn\'t support geolocation.';
                div.html('<p>' + content + '</p>')
            }
        }


        //google.maps.event.addDomListener(window, 'load', initialize);

        google.maps.event.addDomListener(window, 'resize', function() {
            map.setCenter(pos);
        });
    </script>
@endsection


