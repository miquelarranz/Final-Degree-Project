<?php namespace services;


use repositories\OpenDataCityRepository;
use repositories\OpenDataSourceRepository;
use repositories\UserRepository;

class OpenDataService {

    protected $openDataCityRepository;

    protected $openDataSourceRepository;

    private $userRepository;

    function __construct(OpenDataCityRepository $openDataCityRepository, OpenDataSourceRepository $openDataSourceRepository, UserRepository $userRepository)
    {
        $this->openDataCityRepository = $openDataCityRepository;
        $this->openDataSourceRepository = $openDataSourceRepository;
        $this->userRepository = $userRepository;
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

    public function deleteAnOpenDataSource($id)
    {
        $sources = $this->openDataSourceRepository->all();

        $sourceToDelete = $this->openDataSourceRepository->read($id);

        $sourcesWithTheSameCity = 0;
        foreach ($sources as $source)
        {
            if ($source->city == $sourceToDelete->city) $sourcesWithTheSameCity = $sourcesWithTheSameCity + 1;
        }

        if ($sourcesWithTheSameCity == 1)
        {
            $cityId = $sourceToDelete->city;

            $users = $this->userRepository->all(array('defaultCity' => $sourceToDelete->city));

            if ( ! empty($users))
            {
                foreach ($users as $user)
                {
                    $user->updateTheDefaultCity(null);
                    $user->save();
                }
            }

            $this->openDataSourceRepository->delete($id);
            $this->openDataCityRepository->delete($cityId);
        }
        else
        {
            $this->openDataSourceRepository->delete($id);
        }
    }

    public function updateAnOpenDataSource($data)
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

        if ( ! is_null($data['configurationFile']))
        {
            $configurationFile = $data['configurationFile'];

            $data['configurationFilePath'] = "/files/" . $configurationFile->getClientOriginalName();

            $configurationFile->move(public_path() . "/files/", $configurationFile->getClientOriginalName());
        }
        else
        {
            $data['configurationFilePath'] = "";
        }

        $sourceToUpdate = $this->openDataSourceRepository->read($data['id']);
        $oldCityId = $sourceToUpdate->city;

        $updatedSource = $this->openDataSourceRepository->update($data);

        $sources = $this->openDataSourceRepository->all();

        $sourcesWithTheSameCity = 0;
        foreach ($sources as $source)
        {
            if ($source->city == $oldCityId) $sourcesWithTheSameCity = $sourcesWithTheSameCity + 1;
        }

        if ($sourcesWithTheSameCity == 0)
        {
            $users = $this->userRepository->all(array('defaultCity' => $oldCityId));

            if ( ! empty($users))
            {
                foreach ($users as $user)
                {
                    $user->updateTheDefaultCity(null);
                    $user->save();
                }
            }
            $this->openDataCityRepository->delete($oldCityId);
        }

        return $updatedSource;
    }

    public function getASource($id)
    {
        return $this->openDataSourceRepository->read($id);
    }
}