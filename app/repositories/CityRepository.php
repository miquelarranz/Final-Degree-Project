<?php namespace repositories;

use City;

class CityRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return City::find($id);
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $city = $this->read($id);

        $city->delete();
    }
}
