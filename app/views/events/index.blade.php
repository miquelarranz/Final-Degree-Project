@extends(Auth::user() ? 'layouts.auth' : 'layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.partials.errors')

            @include('events.partials.filters')

            <h1 class="text-center white-color title-margin">Events list</h1>
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
                <p>Error</p>
            @endif
        </div>
    </div>

@endsection


