<?php namespace repositories;

use Place;

class PlaceRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        $place = Place::createAPlace($data['id']);

        $place->save();

        return $place;
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
