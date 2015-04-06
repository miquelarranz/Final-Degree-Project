<?php

class CountryTableSeeder extends Seeder {

    protected $placeRepository;

    protected $administrativeAreaRepository;

    protected $countryRepository;

    protected $thingRepository;

    /**
     * @param PlaceRepository $placeRepository
     * @param AdministrativeAreaRepository $administrativeAreaRepository
     * @param CountryRepository $countryRepository
     * @param ThingRepository $thingRepository
     */
    function __construct(PlaceRepository $placeRepository, AdministrativeAreaRepository $administrativeAreaRepository, CountryRepository $countryRepository, ThingRepository $thingRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->administrativeAreaRepository = $administrativeAreaRepository;
        $this->countryRepository = $countryRepository;
        $this->thingRepository = $thingRepository;
    }

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$file = File::get(public_path() . '/files/Countries.txt');

        $countries = explode(',', $file);

        foreach($countries as $countryName)
        {
            $thing = Thing::createAThing(null, null, null, trim($countryName));
            $thing = $this->thingRepository->save($thing);

            $place = Place::createAPlace($thing->id);
            $this->placeRepository->save($place);

            $administrativeArea = AdministrativeArea::createAnAdministrativeArea($thing->id);
            $this->administrativeAreaRepository->save($administrativeArea);

            $country = Country::createACountry($thing->id);
            $this->countryRepository->save($country);
        }
    }

}
