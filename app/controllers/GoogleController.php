<?php

use services\EventsService;
use services\GoogleService;
use services\OpenDataService;

class GoogleController extends \BaseController {

    private $googleService;

    private $eventsService;

    private $openDataService;

    function __construct(GoogleService $googleService, EventsService $eventsService, OpenDataService $openDataService)
    {
        //$this->beforeFilter('auth');
        //$this->beforeFilter('user');
        $this->googleService = $googleService;
        $this->eventsService = $eventsService;
        $this->openDataService = $openDataService;
    }

    public function login() {

        $code = Input::get( 'code' );

        $result = $this->googleService->login($code);
        if ( ! is_null($result)) {
            return Redirect::to($result);
        }

        $calendars = $this->googleService->getTheCalendarList();

        if (empty($calendars))
        {
            if (empty($calendars)) Flash::error(Lang::get('messages.google/calendarError'));

            return Redirect::back();
        }

        if ( ! Session::get('event')) return Redirect::route('events_path');

        $event = $this->eventsService->getAnEvent(Session::get('event'));
        $endDate = null;
        $endTime = null;
        $startDate = null;
        $startTime = null;
        if ( ! is_null($event->endDate))
        {
            $eventEndDate = new \DateTime($event->endDate);
            $endDate = $eventEndDate->format('Y/m/d');
            $endTime = $eventEndDate->format('H:i:s');
        }
        if ( ! is_null($event->startDate))
        {
            $eventStartDate = new \DateTime($event->startDate);
            $startDate = $eventStartDate->format('Y/m/d');
            $startTime = $eventStartDate->format('H:i:s');
        }

        return View::make('google.calendars')->with(array('calendars' => $calendars, 'startDate' => $startDate, 'startTime' => $startTime, 'endDate' => $endDate, 'endTime' => $endTime));
    }

    public function addEvent()
    {
        $eventId = Session::get('event');
        $calendarId = Input::get('calendar');

        $startDate = Input::get('startDate');
        $startTime = Input::get('startTime');
        $endDate = Input::get('endDate');
        $endTime = Input::get('endTime');

        $validator = Validator::make(
            [
                'startDate' => $startDate,
                'startTime' => $startTime,
                'endDate' => $endDate,
                'endTime' => $endTime,
            ],
            [
                'startDate' => 'required|date',
                'endDate' => 'required|date',
                'startTime' => 'required',
                'endTime' => 'required',
            ]
        );

        if ($validator->fails())
        {
            $errors = $validator->messages();
            return Redirect::back()->withInput()->with(array('errors' => $errors));
        }

        try
        {
            $this->googleService->addEvent($eventId, $calendarId, $startDate, $startTime, $endDate, $endTime);
        }
        catch (\Exception $e)
        {
            if ($e->getMessage() == 'dates') Flash::error(Lang::get('messages.calendar/dates'));
            else Flash::error(Lang::get('messages.calendar/error'));
            return Redirect::back()->withInput();
        }

        Flash::message(Lang::get('messages.google/added'));

        return Redirect::route('event_path', array('id' => $eventId));
    }

    public function geolocate()
    {
        $city = Input::get('city');

        $exists = -1;

        $openDataCities = $this->openDataService->getAllTheCities();

        foreach ($openDataCities as $key => $value)
        {
            if ($value == $city) $exists = $key;
        }

        return Response::json(array(
            'data'   => $exists
        ));
    }
}
