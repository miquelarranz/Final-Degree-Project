<?php

use services\OpenDataService;

class PagesController extends \BaseController {

    private $openDataService;

    /**
     * @param OpenDataService $openDataService
     */
    function __construct(OpenDataService $openDataService)
    {
        $this->openDataService = $openDataService;
    }

    public function home()
    {
        $cities = $this->openDataService->getAllTheCities();

        return View::make('pages.home')->with(array('cities' => $cities));
    }

}
