<?php namespace services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use repositories\EventPersonRepository;
use repositories\EventRepository;
use repositories\SubscribedEventRepository;
use repositories\UserRepository;

class EventsService {

    protected $eventRepository;

    protected $subscribedEventRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository, EventRepository $eventRepository, SubscribedEventRepository $subscribedEventRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
        $this->subscribedEventRepository = $subscribedEventRepository;
    }

    public function getFilteredEvents($data)
    {
        $dataArray = array();

        $now = new \DateTime();
        $now->setTime(0, 0, 0);

        $startDateTimestamp = 0;
        $endDateTimestamp = 0;
        $limit = '50';

        if ( ! empty($data))
        {
            if (array_key_exists('limit', $data))
            {
                if ($data['limit'] != "")
                {
                    $dataArray['limit'] = $data['limit'];
                }
            }

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

    public function getAnEvent($id)
    {
        return $this->eventRepository->read($id);
    }

    public function getAnEventPDF($id)
    {
        $pdf = App::make('dompdf');

        $event = $this->eventRepository->read($id);

        $html = View::make('events.download')->with(array('event' => $event))->render();

        $pdf->loadHTML($html);

        return $pdf->download("event-$event->id.pdf");
    }

    public function subscribe($id)
    {
        $event = $this->eventRepository->read($id);

        $address = $this->getAddress($event);

        $this->subscribedEventRepository->create(array('name' => $event->thing->name, 'url' => $event->thing->url, 'description' => $event->thing->description, 'startDate' => $event->startDate, 'address' => $address, 'city' => $event->eventLocation->thing->name, 'user' => Auth::id(), 'type' => $event->type, 'associatedEvent' => $id));
    }

    public function unsubscribe($id)
    {
        $subscribedEvent = $this->subscribedEventRepository->read($id);

        $eventId = $subscribedEvent->associatedEvent;

        $this->subscribedEventRepository->delete($id);

        return $eventId;
    }

    public function isSubscribed($id)
    {
        $subscribedEvents = Auth::user()->events;

        foreach ($subscribedEvents as $subscribedEvent)
        {
            if ($subscribedEvent->associatedEvent == $id) return true;
        }

        return false;
    }

    private function getAddress($event)
    {
        $address = null;
        $first = true;

        if ( ! is_null($event->eventLocation->address))
        {
            if ( ! is_null($event->eventLocation->postalAddress->streetAddress))
            {
                if ($first) {
                    $address = $address . $event->eventLocation->postalAddress->streetAddress;
                    $first = false;
                }
                else $address = $address . ', ' . $event->eventLocation->postalAddress->streetAddress;
            }
            if ( ! is_null($event->eventLocation->postalAddress->addressRegion))
            {
                if ($first) {
                    $address = $address . $event->eventLocation->postalAddress->streetAddress;
                    $first = false;
                }
                else $address = $address . ', ' . $event->eventLocation->postalAddress->streetAddress;
            }
            if ( ! is_null($event->eventLocation->postalAddress->postalCode))
            {
                if ($first) {
                    $address = $address . $event->eventLocation->postalAddress->streetAddress;
                    $first = false;
                }
                else $address = $address . ', ' . $event->eventLocation->postalAddress->streetAddress;
            }
        }

        return $address;
    }

    public function hasDate($id)
    {
        $event = $this->eventRepository->read($id);

        if (is_null($event->startDate) or is_null($event->endDate)) return false;
        else return true;
    }
}