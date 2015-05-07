<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class City extends AdministrativeArea {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    public $timestamps = false;

    protected $fillable = array('id');

    public function administrativeArea()
    {
        return $this->belongsTo('AdministrativeArea', 'id', 'id');
    }
}
