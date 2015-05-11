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
        if (is_null($id) and ! is_null($related))
        {
            return OpenDataCity::where($related)->first();
        }
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
