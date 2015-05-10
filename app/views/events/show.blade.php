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
                        <p class="text-center"><b> {{ $event->startDate }} - {{ $event->finishDate }} </b></p>
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
                                @if ( ! is_null($event->performers))
                                    <div class="row text-centered">
                                        <div class="col-xs-12">
                                            @lang('messages.event/performers')
                                        </div>
                                        @foreach($event->performers as $performer)
                                            <div class="col-xs-12">
                                                {{ $performer->thing->name }} @if( ! is_null($performer->email)) <span class="glyphicon glyphicon-envelope performer-icon" aria-hidden="true"></span> @endif
                                            </div>
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
                                        <div class="panel-collapse collapse profile-delete-button" id="calendar">
                                            <div class="panel-body">
                                                <div class = "text-center form-group">
                                                    <a href="{{ URL::route('google_login_path') }}" class="btn btn-default form-control event-add-button">@lang('messages.event/calendar')</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 data-toggle="collapse" class="text-center panel-title" href="#location" aria-expanded="true" aria-controls="collapseOne">
                                            <a class="filters-title">
                                                @lang('messages.event/location')
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="location">
                                        <div class="panel-body">

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


