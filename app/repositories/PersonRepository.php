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
        return Person::find($id);
    }

    public function update(array $data)
    {
        $person = $this->read($data['id']);

        $person->updateAPerson($data['lastName'], $data['birthDate'], $data['gender'], $data['nationality']);

        $person->save();

        return $person;
    }

    public function delete($id)
    {
        $person = $this->read($id);

        $person->delete();
    }
}
