<?php

use Larabook\Forms\RegistrationForm;
use Larabook\Registration\RegisterCommand;
use Larabook\Core\CommandBus;

class RegistrationController extends \BaseController {

    function __construct()
    {
        $this->beforeFilter('guest');
    }

	/**
	 * Show a form to register the user
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('registration.create');
	}

    /**
     * Create a new Larabook user
     *
     * @return string
     */
    public function store()
    {
        extract(Input::only('username', 'email', 'password'));

        $validator = Validator::make(
            [
                'username' => $username,
                'password' => $password,
                'email' => $email
            ],
            [
                'name' => 'required',
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users'
            ]
        );



        Auth::login($user);

        return Redirect::home();
    }

}
