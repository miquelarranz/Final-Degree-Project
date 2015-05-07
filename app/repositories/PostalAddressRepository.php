<?php namespace repositories;

use PostalAddress;

class PostalAddressRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return PostalAddress::find($id);
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $postalAddress = $this->read($id);

        $postalAddress->delete();
    }
}
