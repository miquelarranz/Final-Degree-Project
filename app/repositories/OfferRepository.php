<?php namespace repositories;

use Offer;

class OfferRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return Offer::find($id);
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $offer = $this->read($id);

        $offer->delete();
    }
}
