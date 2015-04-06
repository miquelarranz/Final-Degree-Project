<?php


class PersonRepository {

    /**
     * Persist a person
     *
     * @param Person $person
     * @return mixed
     */
    public function save(Person $person)
    {
        $person->save();

        return $person;
    }
}
