<a href="{{ URL::route('event_path', array('id' => $event->id)) }}" class="event-link">
    <div class="thumbnail event-container">
            @if (is_null($event->thing->image))
                <img class="img-responsive img-thumbnail event-image" src="/images/images-background.jpeg" alt="Event">
            @else
                <img class="img-responsive img-thumbnail event-image" src="{{ $event->thing->image }}" alt="Event">
            @endif
        <div class="caption">
            <h3 class="text-center event-title" title="{{ $event->thing->name }}"> {{ str_limit(utf8_decode($event->thing->name), 30) }} </h3>
            @if ( ! is_null($event->startDate))
                <p class="text-center"><b> {{ $event->startDate }} </b></p>
            @else
                <p class="text-center event-permanent"><b> @lang('messages.event/date') </b></p>
            @endif
            <p class="text-center event-type" title="{{ $event->type }}"> {{ str_limit(utf8_decode($event->type), 50) }}</p>
        </div>
    </div>
 </a>