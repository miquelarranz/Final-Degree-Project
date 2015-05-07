<?php namespace repositories;

use StructuredValue;

class StructuredValueRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return StructuredValue::find($id);
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $structuredValue = $this->read($id);

        $structuredValue->delete();
    }
}
