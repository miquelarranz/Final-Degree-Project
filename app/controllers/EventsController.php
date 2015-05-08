<?php

use services\EventsService;
use services\OpenDataService;

class EventsController extends \BaseController {

    private $openDataService;

    private $eventsService;

    /**
     * @param OpenDataService $openDataService
     * @param EventsService $eventsService
     */
    function __construct(OpenDataService $openDataService, EventsService $eventsService)
    {
        $this->beforeFilter('auth');
        $this->openDataService = $openDataService;
        $this->eventsService = $eventsService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $cities = $this->openDataService->getAllTheCities();

        dd(GeoIP::getLocation(Request::getClientIp(true)));

        return View::make('events.index')->with(array('cities' => $cities));
    }

    public function filter()
    {
        extract(Input::only('startDate', 'endDate'));

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
        }

        $events = $this->eventsService->getFilteredEvents(Input::all());
        //dd($events);
        return Redirect::route('events_path')->with(array('events' => $events));
    }
}
