<?php namespace repositories;

use Thing;

class ThingRepository {

    /**
     * Persist a thing
     *
     * @param Thing $thing
     * @return mixed
     */
    public function save(Thing $thing)
    {
        $thing->save();

        return $thing;
    }
}
