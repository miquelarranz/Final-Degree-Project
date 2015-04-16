<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class AdministrativeArea extends Place {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'administrativeAreas';

    public $timestamps = false;

    protected $fillable = array('id');

    public function place()
    {
        return $this->belongsTo('Place', 'id', 'id');
    }

    public static function createAnAdministrativeArea($id)
    {
        $administrativeArea = new static(compact('id'));

        return $administrativeArea;
    }

}
