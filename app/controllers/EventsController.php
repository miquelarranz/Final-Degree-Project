<?php

class EventsController extends \BaseController {

    /**
     *
     */
    function __construct()
    {
        $this->beforeFilter('auth');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return View::make('events.index');
    }
}
