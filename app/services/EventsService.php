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

        if ( ! empty($data))
        {
            if (array_key_exists('startDate', $data))
            {
                if ($data['startDate'] != "")
                {
                    $date = new \DateTime($data['startDate']);
                    $startDateTimestamp = $startDateTimestamp + $date->getTimestamp();
                }
            }

            if (array_key_exists('startTime', $data))
            {
                if ($data['startTime'] != "")
                {
                    $startDateTimestamp = $startDateTimestamp + strtotime($data['startTime']) - $now->getTimestamp();
                }
            }

            if (array_key_exists('endDate', $data))
            {
                if ($data['endDate'] != "")
                {
                    $date = new \DateTime($data['endDate']);
                    $endDateTimestamp = $endDateTimestamp + $date->getTimestamp();
                }
            }

            if (array_key_exists('endTime', $data))
            {
                if ($data['endTime'] != "")
                {
                    $endDateTimestamp = $endDateTimestamp + strtotime($data['endTime']) - $now->getTimestamp();
                }
            }

            if ($startDateTimestamp != 0) $dataArray['startDate'] = date('m/d/Y H:i:s', $startDateTimestamp);
            if ($endDateTimestamp != 0) $dataArray['endDate'] = date('m/d/Y H:i:s', $endDateTimestamp);

            if (array_key_exists('type', $data))
            {
                if ($data['type'] != "") $dataArray['type'] = $data['type'];
            }

            if (array_key_exists('name', $data))
            {
                if ($data['name'] != "") $dataArray['name'] = $data['name'];
            }

            if (array_key_exists('city', $data))
            {
                if ($data['city'] != "")
                {
                    $dataArray['location'] = $data['city'];
                    if (Auth::check()) $this->userRepository->update(array('city' => $data['city'], 'id' => Auth::id()));
                }
            }

        }

        if (empty($dataArray) and Auth::check())
        {
            if (is_null(Auth::user()->defaultCity))
            {
                $result = $this->eventRepository->all();
                return $result->all();
            }
            else {
                return $this->eventRepository->all(array('location' => Auth::user()->defaultCity));
            }
        }
        else
        {
            if (empty($dataArray)) {
                $result = $this->eventRepository->all();
                return $result->all();
            }
            else  return $this->eventRepository->all($dataArray);
        }
    }
}