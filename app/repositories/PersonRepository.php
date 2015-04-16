<?php namespace repositories;

use Person;

class PersonRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        $person = Person::createAPerson($data['id'], $data['lastName'], $data['birthDate'], $data['nationality'], $data['gender']);

        $person->save();

        return $person;
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
