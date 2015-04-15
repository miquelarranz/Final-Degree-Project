<?php namespace services;

use repositories\CountryRepository;

class PlacesService {

    protected $countryRepository;

    /**
     * @param CountryRepository $countryRepository
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getAllTheCountries()
    {
        return $this->countryRepository->all();
    }


}