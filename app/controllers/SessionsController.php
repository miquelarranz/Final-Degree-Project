<?php

class SessionsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('guest', ['except' => 'destroy']);
    }


    /**
	 * Show the form for signing in.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');
	}


	/**
	 * Authenticates the user, if their credentials are valid.
	 *
	 * @return Response
	 */
	public function store()
	{
        extract(Input::only('email', 'password'));

        $validator = Validator::make(
            [
                'email' => $email,
                'password' => $password
            ],
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );

        $formData = Input::only('email', 'password');

        if (Auth::attempt($formData))
        {
            if (Auth::user()->role == 'systemAdministrator')
            {
                return Redirect::intended('sources');
            }
            else
            {
                return Redirect::intended('events');
            }
        }

        Flash::error(Lang::get('messages.login/error'));

        return Redirect::back()->withInput();
	}

    /**
     * Log a user out of Larabook.
     *
     * @return Mixed
     */
    public function destroy()
    {
        Auth::logout();

        return Redirect::home();
    }
}
