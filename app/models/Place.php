<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Place extends Thing {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'places';

    public $timestamps = false;

    protected $fillable = array('id', 'address', 'geo', 'containedIn');

    public function thing()
    {
        return $this->belongsTo('Thing', 'id', 'id');
    }

    public function postalAddress()
    {
        return $this->belongsTo('PostalAddress', 'address');
    }

    public function geoCoordinates()
    {
        return $this->belongsTo('GeoCoordinates', 'geo');
    }

    public static function createAPlace($id, $address = null, $geo = null, $containedIn = null)
    {
        $place = new static(compact('id', 'address', 'geo', 'containedIn'));

        return $place;
    }
}
