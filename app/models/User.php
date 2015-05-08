<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    protected $fillable = array('email', 'password', 'role', 'person');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    public function relatedPerson()
    {
        return $this->belongsTo('Person', 'person');
    }

    public function city()
    {
        return $this->belongsTo('OpenDataCity', 'defaultCity');
    }

    /**
     * Password must always be hashed.
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public static function registerAUser($email, $password, $person)
    {
        $role = 'registeredUser';
        $user = new static(compact('email', 'password', 'role', 'person'));

        return $user;
    }

    public function updateAUser($password)
    {
        $this->setPasswordAttribute($password);
    }

    public function updateTheDefaultCity($city)
    {
        $this->attributes['defaultCity'] = $city;
    }
}
