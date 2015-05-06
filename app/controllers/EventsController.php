<?php

use services\OpenDataService;

class EventsController extends \BaseController {

    private $openDataService;

    /**
     * @param OpenDataService $openDataService
     */
    function __construct(OpenDataService $openDataService)
    {
        $this->beforeFilter('auth');
        $this->openDataService = $openDataService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $cities = $this->openDataService->getAllTheCities();

        return View::make('events.index')->with(array('cities' => $cities));
    }
}
