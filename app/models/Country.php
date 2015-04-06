<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Country extends AdministrativeArea {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    protected $fillable = array('id');

    public function administrativeArea()
    {
        return $this->belongsTo('AdministrativeArea', 'id', 'id');
    }

    public static function createACountry($id)
    {
        $country = new static(compact('id'));

        return $country;
    }

}
