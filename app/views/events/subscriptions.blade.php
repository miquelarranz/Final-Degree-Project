@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')

            <h1 class="text-center white-color title-margin">@lang('messages.subscriptions/title')</h1>

            @if(count($subscribedEvents) > 0)
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach ($subscribedEvents as $event)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading{{ $event->id }}">
                            <div class="panel-title" style="display:inline-block; width: 89%">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $event->id }}" aria-expanded="true" aria-controls="collapse{{ $event->id }}">
                                    {{ utf8_decode($event->name) }}
                                </a>
                            </div>
                            <div class="panel-title" style="display:inline-block; width: 10%">
                                <a href="{{ URL::route('event_unsubscription_path', array('id' => $event->id)) }}">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                        <div id="collapse{{ $event->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $event->id }}">
                            <div class="panel-body">
                                @if ( ! is_null($event->startDate))
                                    <p><b style="padding-right: 10px;">@lang('messages.filters/startDate'):</b> {{ $event->startDate }}</p>
                                @else
                                    <p class="event-permanent">@lang('messages.event/date')</p>
                                @endif
                                @if ( ! is_null($event->description))
                                    <p><b style="padding-right: 10px;">@lang('messages.event/description'):</b> {{ utf8_decode($event->description) }}</p>
                                @endif
                                @if ( ! is_null($event->url))
                                    <p><b style="padding-right: 10px;">@lang('messages.event/url'):</b> {{ $event->url }}</p>
                                @endif
                                @if ( ! is_null($event->address))
                                    <p><b style="padding-right: 10px;">@lang('messages.subscriptions/address'):</b> {{ utf8_decode($event->address) }}</p>
                                @endif
                                @if ( ! is_null($event->type))
                                    <p><b style="padding-right: 10px;">@lang('messages.filters/type'):</b> {{ utf8_decode($event->type) }}</p>
                                @endif
                                @if ( ! is_null($event->city))
                                    <p><b style="padding-right: 10px;">@lang('messages.event/city'):</b> {{ utf8_decode($event->city) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center panel-title">
                            @lang('messages.subscriptions/noSubscriptionsTitle')
                        </h3>
                    </div>
                    <div class="text-center panel-body">
                        @lang('messages.subscriptions/noSubscriptionsText')
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection