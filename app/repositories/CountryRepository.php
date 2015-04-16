<?php namespace repositories;

use Country;

class CountryRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        return Country::all();
    }

    public function create(array $data)
    {
        $country = Country::createACountry($data['id']);

        $country->save();

        return $country;
    }

    public function read($id, array $related = null)
    {
        // TODO: Implement read() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
