<?php namespace repositories;

use Organization;

class OrganizationRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return Organization::find($id);
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $organization = $this->read($id);

        $organization->delete();
    }
}
