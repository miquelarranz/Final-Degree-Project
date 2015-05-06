<?php namespace repositories;

use OpenDataCity;

class OpenDataCityRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        return OpenDataCity::all();
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
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
