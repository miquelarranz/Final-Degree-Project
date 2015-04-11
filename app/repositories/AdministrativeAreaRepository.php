<?php namespace repositories;

use AdministrativeArea;

class AdministrativeAreaRepository extends Repository {

    /**
     * Persist a country
     *
     * @param AdministrativeArea $administrativeArea
     * @return mixed
     */
    public function save(AdministrativeArea $administrativeArea)
    {
        $administrativeArea->save();

        return $administrativeArea;
    }
}
