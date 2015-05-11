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
            $citiesArray[$city->id] = utf8_decode($city->name);
        }

        return $citiesArray;
    }

    public function getACityIdentifier($data)
    {
        $openDataCity = $this->openDataCityRepository->read(null, $data);

        if (is_null($openDataCity)) return null;
        else return $openDataCity->id;
    }
}