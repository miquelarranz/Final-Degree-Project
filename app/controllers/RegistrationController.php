<?php

use Larabook\Forms\RegistrationForm;
use Larabook\Registration\RegisterCommand;
use Larabook\Core\CommandBus;

class RegistrationController extends \BaseController {

    protected $userRepository;

    protected $personRepository;

    protected $thingRepository;

    /**
     * @param UserRepository $userRepository
     * @param PersonRepository $personRepository
     * @param ThingRepository $thingRepository
     */
    function __construct(UserRepository $userRepository, PersonRepository $personRepository, ThingRepository $thingRepository)
    {
        $this->userRepository = $userRepository;
        $this->personRepository = $personRepository;
        $this->thingRepository = $thingRepository;
    }

    /**
	 * Show a form to register the user
	 *
	 * @return Response
	 */
	public function create()
	{
        $countryNames = array();

        $countries = Country::all();

        foreach ($countries as $country)
        {
            $countryNames[] = $country->administrativeArea->place->thing->name;
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

        $user = User::registerAUser($email, $password);
        $this->userRepository->save($user);

        $thing = Thing::createAThing(null, null, null, $name);
        $thing = $this->thingRepository->save($thing);

        $person = Person::createAPerson($thing->id, $email, $familyName, $birthDate, $nationality, $gender);
        $this->personRepository->save($person);

        Auth::login($user);

        return Redirect::home();
    }

}
