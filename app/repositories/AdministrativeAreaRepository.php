<?php namespace repositories;

use AdministrativeArea;

class AdministrativeAreaRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        $administrativeArea = AdministrativeArea::createAnAdministrativeArea($data['id']);

        $administrativeArea->save();

        return $administrativeArea;
    }

    public function read($id, array $related = null)
    {
        return AdministrativeArea::find($id);
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        $administrativeArea = $this->read($id);

        $administrativeArea->delete();
    }
}
