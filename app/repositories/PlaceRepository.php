<?php namespace repositories;

use Place;

class PlaceRepository {

    /**
     * Persist a country
     *
     * @param Place $place
     * @return mixed
     */
    public function save(Place $place)
    {
        $place->save();

        return $place;
    }
}
