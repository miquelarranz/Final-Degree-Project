<?php namespace services;

use repositories\PersonRepository;
use repositories\ThingRepository;
use repositories\UserRepository;

class UsersService {

    protected $userRepository;

    protected $personRepository;

    protected $thingRepository;

    /**
     * @param UserRepository $userRepository
     * @param PersonRepository $personRepository
     * @param ThingRepository $thingRepository
     */
    public function __construct(UserRepository $userRepository, PersonRepository $personRepository, ThingRepository $thingRepository)
    {
        $this->userRepository = $userRepository;
        $this->personRepository = $personRepository;
        $this->thingRepository = $thingRepository;
    }

    public function updateAUser($id, $data)
    {
        $user = $this->userRepository->update(array('id' => $id, 'password' => $data['password']));

        $person = $this->personRepository->update(array('id' => $user->person, 'lastName' => $data['lastName'], 'birthDate' => $data['birthDate'], 'nationality' => $data['nationality'], 'gender' => $data['gender']));

        $thing = $this->thingRepository->update(array('id' => $person->id, 'name' => $data['name']));
    }

    public function deleteAUser($id)
    {
        $user = $this->userRepository->read($id);

        $personId = $user->person;

        $thingId = $user->relatedPerson->thing->id;

        $this->userRepository->delete($id);

        $this->personRepository->delete($personId);

        $this->thingRepository->delete($thingId);
    }


}