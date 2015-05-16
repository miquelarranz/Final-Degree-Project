@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')

            @foreach ($subscribedEvents as $event)
                <p>{{ $event->name }}</p>
                <p>{{ $event->associatedEvent }}</p>
                <div class = "text-center form-group">
                    <a href="{{ URL::route('event_unsubscription_path', array('id' => $event->id)) }}" class="btn btn-success form-control event-download-button">@lang('messages.event/unsubscribe')</a>
                </div>
            @endforeach
        </div>
    </div>

@endsection