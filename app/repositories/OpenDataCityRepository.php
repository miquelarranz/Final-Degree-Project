<?php namespace repositories;

use OpenDataCity;

class OpenDataCityRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        return OpenDataCity::all();
    }

    public function create(array $data)
    {
        $city = OpenDataCity::createAnOpenDataCity(utf8_encode($data['name']));

        $city->save();

        return $city;
    }

    public function read($id, array $related = null)
    {
        if (is_null($id) and ! is_null($related))
        {
            return OpenDataCity::where($related)->first();
        }
        else {
            return OpenDataCity::find($id);
        }
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        $city = $this->read($id);

        $city->delete();
    }
}
