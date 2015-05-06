<?php namespace services;


use repositories\OpenDataCityRepository;

class OpenDataService {

    protected $openDataCityRepository;

    function __construct(OpenDataCityRepository $openDataCityRepository)
    {
        $this->openDataCityRepository = $openDataCityRepository;
    }

    public function getAllTheCities()
    {
        $cities = $this->openDataCityRepository->all();

        $citiesArray = array();

        foreach ($cities as $city)
        {
            $citiesArray[$city->id] = $city->name;
        }

        return $citiesArray;
    }
}