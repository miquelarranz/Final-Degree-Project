<?php namespace repositories;

use ContactPoint;

class ContactPointRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return ContactPoint::find($id);
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $contactPoint = $this->read($id);

        $contactPoint->delete();
    }
}
