<?php

use services\EventsService;
use services\GoogleService;
use services\OpenDataService;

class EventsController extends \BaseController {

    private $openDataService;

    private $googleService;

    private $eventsService;

    /**
     * @param OpenDataService $openDataService
     * @param EventsService $eventsService
     */
    function __construct(OpenDataService $openDataService, EventsService $eventsService, GoogleService $googleService)
    {
        //$this->beforeFilter('auth', array('except' => 'getLogin'));
        $this->openDataService = $openDataService;
        $this->eventsService = $eventsService;
        $this->googleService = $googleService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $cities = $this->openDataService->getAllTheCities();

        //dd(GeoIP::getLocation(Request::getClientIp(true)));

        $events = $this->eventsService->getFilteredEvents(array());

        return View::make('events.index')->with(array('cities' => $cities, 'events' => $events));
    }

    public function filter()
    {
        /*extract(Input::only('startDate', 'endDate'));

        $validator = Validator::make(
            [
                'startDate' => $startDate,
                'endDate' => $endDate
            ],
            [
                'startDate' => 'date',
                'endDate' => 'date',
            ]
        );

        if ($validator->fails())
        {
            $errors = $validator->messages();
            return Redirect::back()->withInput()->with(array('errors' => $errors));
        }*/

        $events = $this->eventsService->getFilteredEvents(Input::all());
        $cities = $this->openDataService->getAllTheCities();

        return View::make('events.index')->with(array('cities' => $cities, 'events' => $events));
    }

    public function show($id)
    {
        $event = $this->eventsService->getAnEvent($id);
        $similarEvents = array();

        Session::put('event', $id);

        $cityId = $this->openDataService->getACityIdentifier(array('name' => $event->eventLocation->thing->name));

        if (is_null($cityId)) $cityId = Auth::user()->city->id;

        if ( ! is_null($cityId))  {
            $events = $this->eventsService->getFilteredEvents(array('city' => $cityId, 'limit' => 4));

            foreach ($events as $similarEvent)
            {
                if ($similarEvent->id != $event->id) $similarEvents[] = $similarEvent;
            }
        }

        $subscribed = false;
        if (Auth::user())
        {
            $subscribed = $this->eventsService->isSubscribed($id);
        }

        return View::make('events.show')->with(array('event' => $event, 'similarEvents' => $similarEvents, 'subscribed' => $subscribed));
    }

    public function download($id)
    {
        return $this->eventsService->getAnEventPDF($id);
    }

    public function subscribe($id)
    {
        $this->eventsService->subscribe($id);

        return Redirect::route('event_path', ['id' => $id]);
    }

    public function unsubscribe($id)
    {
        $eventId = $this->eventsService->unsubscribe($id);

        return Redirect::route('event_path', ['id' => $eventId]);
    }

    public function subscriptions()
    {
        $subscribedEvents = Auth::user()->events;

        return View::make('events.subscriptions')->with(array('subscribedEvents' => $subscribedEvents));
    }

}
