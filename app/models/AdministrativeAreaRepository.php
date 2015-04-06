<?php


class AdministrativeAreaRepository {

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
