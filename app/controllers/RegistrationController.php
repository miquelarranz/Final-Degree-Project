<?php

use services\PlacesService;
use services\RegistrationService;

class RegistrationController extends \BaseController {

    protected $registrationService;
    /**
     * @var PlacesService
     */
    private $placesService;

    /**
     * @param RegistrationService $registrationService
     * @param PlacesService $placesService
     */
    function __construct(RegistrationService $registrationService, PlacesService $placesService)
    {
        $this->registrationService = $registrationService;
        $this->placesService = $placesService;

        $this->beforeFilter('guest');
    }

    /**
	 * Show a form to register the user
	 *
	 * @return Response
	 */
	public function create()
	{
        $countryNames = array();

        $countries = $this->placesService->getAllTheCountries();

        foreach ($countries as $country)
        {
            $countryNames[$country->id] = $country->administrativeArea->place->thing->name;
        }

		return View::make('registration.create')->with(array('countryNames' => $countryNames));
	}

    /**
     * Create a new Larabook user
     *
     * @return string
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
                'email' => $email
            ],
            [
                'name' => 'required',
                'lastName' => 'required',
                'birthDate' => 'required|date',
                'nationality' => 'required',
                'gender' => 'required',
                'password' => 'required|min:5|confirmed',
                'email' => 'required|email|unique:users'
            ]
        );

        if ($validator->fails())
        {
            $errors = $validator->messages();
            return Redirect::back()->withInput()->with(array('errors' => $errors));
        }

        $user = $this->registrationService->registerAUser(Input::all());

        Auth::login($user);

        return Redirect::route('events_path');
    }

}
