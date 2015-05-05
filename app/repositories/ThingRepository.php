<?php namespace repositories;

use Thing;

class ThingRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        $thing = Thing::createAThing(null, null, null, $data['name']);

        $thing->save();

        return $thing;
    }

    public function read($id, array $related = null)
    {
        return Thing::find($id);
    }

    public function update(array $data)
    {
        $thing = $this->read($data['id']);

        $thing->updateAPersonThing($data['name']);

        $thing->save();

        return $thing;
    }

    public function delete($id)
    {
        $thing = $this->read($id);

        $thing->delete();
    }
}
