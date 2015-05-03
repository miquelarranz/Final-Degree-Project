<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Person extends Thing {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'persons';

    public $timestamps = false;

    protected $fillable = array('id', 'familyName', 'birthDate', 'nationality', 'gender');

    public function thing()
    {
        return $this->belongsTo('Thing', 'id', 'id');
    }

    public static function createAPerson($id, $familyName, $birthDate, $nationality, $gender)
    {
        $person = new static(compact('id', 'familyName', 'birthDate', 'nationality', 'gender'));

        return $person;
    }
}
