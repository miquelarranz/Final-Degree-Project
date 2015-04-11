<?php namespace repositories;

use Country;

class CountryRepository {

    /**
     * Persist a country
     *
     * @param Country $country
     * @return mixed
     */
    public function save(Country $country)
    {
        $country->save();

        return $country;
    }
}
