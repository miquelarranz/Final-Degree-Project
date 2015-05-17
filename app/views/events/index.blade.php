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


