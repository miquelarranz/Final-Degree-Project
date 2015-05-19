<?php

use services\EventsService;
use services\GoogleService;

class GoogleController extends \BaseController {

    private $googleService;

    private $eventsService;

    function __construct(GoogleService $googleService, EventsService $eventsService)
    {
        //$this->beforeFilter('auth');
        $this->googleService = $googleService;
        $this->eventsService = $eventsService;
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

        $hasDate = $this->eventsService->hasDate(Session::get('event'));

        return View::make('google.calendars')->with(array('calendars' => $calendars, 'hasDate' => $hasDate));
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

        $this->googleService->addEvent($eventId, $calendarId, $startDate, $startTime, $endDate, $endTime);

        Flash::message(Lang::get('messages.google/added'));

        return Redirect::route('event_path', array('id' => $eventId));
    }
}
