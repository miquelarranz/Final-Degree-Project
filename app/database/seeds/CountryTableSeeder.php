<?php

use services\PlacesService;

class CountryTableSeeder extends Seeder {

    protected $placesService;

    function __construct(PlacesService $placesService)
    {
        $this->placesService = $placesService;
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

        $this->placesService->addCountries($countries);
    }

}
