<?php namespace repositories;

use Intangible;

class IntangibleRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return Intangible::find($id);
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $intangible = $this->read($id);

        $intangible->delete();
    }
}
