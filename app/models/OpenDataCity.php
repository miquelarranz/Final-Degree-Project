<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class OpenDataCity  extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'openDataCities';

    public $timestamps = false;

    protected $fillable = array('id', 'name');

    public static function createAnOpenDataCity($name)
    {
        $city = new static(compact('name'));

        return $city;
    }
}
