<?php

use services\GoogleService;

class GoogleController extends \BaseController {

    private $googleService;

    function __construct(GoogleService $googleService)
    {
        $this->beforeFilter('auth');
        $this->googleService = $googleService;
    }

    public function login() {

        // get data from input
        $code = Input::get( 'code' );


        $result = $this->googleService->login();
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

        return View::make('google.calendars')->with(array('calendars' => $calendars));
    }

    public function addEvent()
    {
        $eventId = Session::get('event');
        $calendarId = Input::get('calendar');

        $this->googleService->addEvent($eventId, $calendarId);

        return Redirect::route('event_path', array('id' => $eventId));
    }

}
