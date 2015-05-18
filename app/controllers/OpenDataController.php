<?php

use services\IntegrationService;
use services\OpenDataService;

class OpenDataController extends \BaseController {

    private $openDataService;

    private $integrationService;

    public function __construct(OpenDataService $openDataService, IntegrationService $integrationService)
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('admin');
        $this->openDataService = $openDataService;
        $this->integrationService = $integrationService;
    }

    public function index()
    {
        $sources = $this->openDataService->getAllTheSources();

        return View::make('openData.index')->with(array('sources' => $sources));
    }

    public function create()
    {
        $cities = $this->openDataService->getAllTheCities();

        return View::make('openData.create')->with(array('cities' => $cities));
    }

    /**
     * Create a new Larabook user
     *
     * @return string
     */
    public function store()
    {
        extract(Input::only('url', 'description', 'city', 'new_city', 'extension', 'updateInterval', 'configurationFile'));

        //dd(Input::all());

        $validator = Validator::make(
            [
                'url' => $url,
                'description' => $description,
                'city' => $city,
                'extension' => $extension,
                'updateInterval' => $updateInterval,
                'configurationFile' => $configurationFile,
            ],
            [
                'url' => 'required',
                'description' => 'required',
                'extension' => 'required',
                'updateInterval' => 'required',
                'configurationFile' => 'required',
            ]
        );

        if ($validator->fails())
        {
            $errors = $validator->messages();
            return Redirect::back()->withInput()->with(array('errors' => $errors));
        }
        if ($city == "" and $new_city == "")
        {
            //TODO: revisar
            Flash::error(Lang::get('messages.openData/nameError'));
            return Redirect::back()->withInput();
        }

        $source = $this->openDataService->createAnOpenDataSource(Input::all());

        $this->integrationService->integrateAnOpenDataSource($source);

        return Redirect::route('sources_path');
    }

    public function updateAll()
    {
        $this->integrationService->cleanAllTheEvents();

        $this->integrationService->updateAllTheSources();

        Flash::message(Lang::get('messages.openData/updated'));

        return Redirect::route('sources_path');
    }

    public function edit($id)
    {
        $cities = $this->openDataService->getAllTheCities();

        $source = $this->openDataService->getASource($id);

        return View::make('openData.edit')->with(array('cities' => $cities, 'source' => $source));
    }

    public function update($id)
    {
        extract(Input::only('url', 'description', 'city', 'new_city', 'extension', 'updateInterval', 'configurationFile'));

        //dd(Input::all());

        $validator = Validator::make(
            [
                'url' => $url,
                'description' => $description,
                'city' => $city,
                'extension' => $extension,
                'updateInterval' => $updateInterval,
            ],
            [
                'url' => 'required',
                'description' => 'required',
                'extension' => 'required',
                'updateInterval' => 'required',
            ]
        );

        if ($validator->fails())
        {
            $errors = $validator->messages();
            return Redirect::back()->withInput()->with(array('errors' => $errors));
        }
        if ($city == "" and $new_city == "")
        {
            //TODO: revisar
            Flash::error(Lang::get('messages.openData/nameError'));
            return Redirect::back()->withInput();
        }

        $this->openDataService->updateAnOpenDataSource(Input::all() + array('id' => $id));

        return Redirect::route('sources_path');
    }

    public function destroy($id)
    {
        $this->openDataService->deleteAnOpenDataSource($id);

        return Redirect::route('sources_path');
    }

}
