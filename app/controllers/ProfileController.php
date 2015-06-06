<?php

use services\PlacesService;
use services\UsersService;

class ProfileController extends \BaseController {

    private $usersService;

    private $placesService;

    function __construct(UsersService $usersService, PlacesService $placesService)
    {
        $this->usersService = $usersService;
        $this->placesService = $placesService;

        $this->beforeFilter('auth');
        $this->beforeFilter('user');
    }

    /**
     * @return mixed
     */
    public function show()
    {
        return View::make('profile.show');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $countryNames = $this->placesService->getAllTheCountries();

        return View::make('profile.create')->with(array('countryNames' => $countryNames));
    }

    /**
     * @return mixed
     */
    public function store()
    {
        extract(Input::only('name', 'email', 'password', 'password_confirmation', 'lastName', 'birthDate', 'nationality', 'gender'));

        $validator = Validator::make(
            [
                'name' => $name,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'lastName' => $lastName,
                'birthDate' => $birthDate,
                'nationality' => $nationality,
                'gender' => $gender,
            ],
            [
                'name' => 'required',
                'lastName' => 'required',
                'birthDate' => 'required|date',
                'nationality' => 'required',
                'gender' => 'required',
                'password' => 'confirmed',
            ]
        );

        if ($validator->fails())
        {
            $errors = $validator->messages();
            return Redirect::back()->withInput()->with(array('errors' => $errors));
        }

        $this->usersService->updateAUser(Auth::id(), Input::all());

        Flash::message(Lang::get('messages.profile/modify'));

        return Redirect::route('profile_path');
    }

    public function delete()
    {
        Flash::message(Lang::get('messages.profile/deleted'));

        $this->usersService->deleteAUser(Auth::id());

        Auth::logout();

        return Redirect::home();
    }
}
