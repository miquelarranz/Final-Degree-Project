<?php namespace repositories;

use GeoCoordinates;

class GeoCoordinatesRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return GeoCoordinates::find($id);
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        $geoCoordinates = $this->read($id);

        $geoCoordinates->delete();
    }
}
