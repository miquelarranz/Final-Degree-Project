<?php namespace services;


use repositories\OpenDataCityRepository;
use repositories\OpenDataSourceRepository;

class OpenDataService {

    protected $openDataCityRepository;

    protected $openDataSourceRepository;

    function __construct(OpenDataCityRepository $openDataCityRepository, OpenDataSourceRepository $openDataSourceRepository)
    {
        $this->openDataCityRepository = $openDataCityRepository;
        $this->openDataSourceRepository = $openDataSourceRepository;
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

    public function getAllTheSources()
    {
        return $this->openDataSourceRepository->all();
    }

    public function createAnOpenDataSource($data)
    {
        if ($data['new_city'] != "")
        {
            $city = $this->openDataCityRepository->read(null, array('name' => $data['new_city']));
            if (is_null($city))
            {
                $city = $this->openDataCityRepository->create(array('name' => $data['new_city']));
            }

            $data['city'] = $city->id;
        }

        $configurationFile = $data['configurationFile'];

        $data['configurationFilePath'] = "/files/" . $configurationFile->getClientOriginalName();

        $configurationFile->move(public_path() . "/files/", $configurationFile->getClientOriginalName());

        $source = $this->openDataSourceRepository->create($data);

        return $source;
    }
}