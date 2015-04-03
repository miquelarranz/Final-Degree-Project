<?php

use Larabook\Forms\SigninForm;

class SessionsController extends \BaseController {

    /**
     * @var SigninForm
     */
    /*private $signInForm;

    public function __construct(SigninForm $signInForm)
    {
        $this->signInForm = $signInForm;

        $this->beforeFilter('guest', ['except' => 'destroy']);
    }*/


    /**
	 * Show the form for signing in.
	 *
	 * @return Response
	 */
	public function create()
	{
        return User::all();
		return View::make('sessions.create');
	}


	/**
	 * Authenticates the user, if their credentials are valid.
	 *
	 * @return Response
	 */
	public function store()
	{
        $formData = Input::only('email', 'password');
        $this->signInForm->validate($formData);

        if (Auth::attempt($formData))
        {
            Flash::message('Welcome back!');
            return Redirect::intended('statuses');
        }

        Flash::error('Your credentials are not correct!');

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

        Flash::message('You have now been logged out.');

        return Redirect::home();
    }
}
