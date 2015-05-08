<?php namespace services;

use Illuminate\Support\Facades\Auth;
use repositories\EventRepository;
use repositories\UserRepository;

class EventsService {

    protected $eventRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository, EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }

    public function getFilteredEvents($data)
    {
        $dataArray = array();

        $now = new \DateTime();
        $now->setTime(0, 0, 0);

        $startDateTimestamp = 0;
        $endDateTimestamp = 0;

        if ($data['startDate'] != "") {
            $date = new \DateTime($data['startDate']);
            $startDateTimestamp = $startDateTimestamp + $date->getTimestamp();
        }

        if ($data['startTime'] != "") {
            $startDateTimestamp = $startDateTimestamp + strtotime($data['startTime']) - $now->getTimestamp();
        }

        if ($data['endDate'] != "") {
            $date = new \DateTime($data['endDate']);
            $endDateTimestamp = $endDateTimestamp + $date->getTimestamp();
        }

        if ($data['endTime'] != "") {
            $endDateTimestamp = $endDateTimestamp + strtotime($data['endTime']) - $now->getTimestamp();
        }

        if ($startDateTimestamp != 0) $dataArray['startDate'] = date('m/d/Y H:i:s', $startDateTimestamp);
        if ($endDateTimestamp != 0) $dataArray['endDate'] = date('m/d/Y H:i:s', $endDateTimestamp);
        if ($data['type'] != "") $dataArray['type'] = $data['type'];
        if ($data['name'] != "") $dataArray['name'] = $data['name'];
        if ($data['city'] != "") $dataArray['city'] = $data['city'];

        if ($data['city'] != "") $this->userRepository->update(array('city' => $data['city'], 'id' => Auth::id()));

        if (empty($dataArray)) $this->eventRepository->all(null);
        else return $this->eventRepository->all($dataArray);
    }
}