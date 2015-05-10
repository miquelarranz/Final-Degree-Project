<?php namespace services;

use Google_Client;
use Illuminate\Support\Facades\Session;
use OAuth;
use redirect;
use repositories\EventRepository;

class GoogleService {

    private $googleService;

    private $eventRepository;

    function __construct(EventRepository $eventRepository)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . '/path/to/google-api-php-client/src');

        $this->eventRepository = $eventRepository;
    }

    public function login2($code)
    {
        $this->googleService = OAuth::consumer( 'Google', 'http://localhost:8000/login/google/' );
        // check if code is valid

        // if code is provided get user data and sign in
        if ( ! empty( $code ) ) {
            // This was a callback request from google, get the token
            Session::put('access_token', $this->googleService->requestAccessToken( $code ));
        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $this->googleService->getAuthorizationUri();
            // return to google login url
            return (string)$url;
        }
    }

    public function getTheCalendarList2()
    {
        $result = json_decode( $this->googleService->request( 'https://www.googleapis.com/calendar/v3/users/me/calendarList' ), true);
        $calendarsArray = array();
        if ( ! is_null($result))
        {
            $calendars = $result['items'];

            foreach ($calendars as $calendar)
            {
                if ($calendar['accessRole'] == 'owner') $calendarsArray[$calendar['id']] = $calendar['summary'];
            }
        }

        return $calendarsArray;
    }

    public function addEvent2($eventId, $calendarId)
    {
        $this->googleService = OAuth::consumer( 'Google', 'http://localhost:8000/login/google/' );

        $event = $this->eventRepository->read($eventId);

        $eventData = array('text' => utf8_decode($event->thing->name));

        $result = json_decode( $this->googleService->request( "https://www.googleapis.com/calendar/v3/calendars/$calendarId/events/quickAdd", "POST", $eventData ), true);

        $data = array();

        if ( ! is_null($event->endDate)) $data['end']['datetime'] = $event->endDate;
        else $data['end'] = $result['end'];
        if ( ! is_null($event->startDate)) $data['start']['datetime'] = $event->startDate;
        else $data['start'] = $result['start'];

        if ( ! is_null($event->thing->url))
        {
            if ((strpos($event->thing->url, 'http://') !== false) or (strpos($event->thing->url, 'https://') !== false)) $data['source']['url'] = $event->thing->url;
            else $data['source']['url'] = 'http://' . $event->thing->url;
        }
        if ( ! is_null($event->thing->description)) $data['description'] = utf8_decode($event->thing->description);
        if ( ! is_null($event->location))
        {
            if ( ! is_null($event->eventLocation->address))
            {
                if ( ! is_null($event->eventLocation->postalAddress->streetAddress)) {
                    $data['location'] = utf8_decode($event->eventLocation->postalAddress->streetAddress) . ", " . utf8_decode($event->eventLocation->thing->name);
                }
            }
        }

        $this->updateAnEvent($calendarId, $eventId, $data);

        //dd("https://www.googleapis.com/calendar/v3/calendars/$calendarId/events/" . $result['id']);
        //dd($data);
        $result = json_decode( $this->googleService->request( "https://www.googleapis.com/calendar/v3/calendars/$calendarId/events/" . $result['id'], "PUT", $data ), true);
        dd($result);

    }

    private function getClient()
    {
        $client = new Google_Client();
        $client->setClientId('781414786878-cl3bd8ctkn2ocbpiikph7bo8mhgl8jjb.apps.googleusercontent.com');
        $client->setClientSecret('BfOUsUkBDfguxCMPBLXlcv7y');
        $client->setRedirectUri('http://localhost:8000/login/google/');
        $client->setScopes('https://www.googleapis.com/auth/calendar');

        return $client;
    }

    public function updateAnEvent($calendarId, $eventId, $data)
    {
        $client = $this->getClient();

        //$token = Session::get('access_token');
        //$client->setAccessToken($token->getAccessToken());

        $calendar_service = new \Google_Service_Calendar($client);

        $event = $calendar_service->events->get($calendarId, $eventId);
        dd($event);
        $updatedEvent = $calendar_service->events->update($calendarId, $eventId, $data);

        dd($updatedEvent);
    }

    public function login()
    {
        $client = $this->getClient();

        $service = new \Google_Service_Calendar($client);
        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['upload_token']);
        }
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['upload_token'] = $client->getAccessToken();
            $_SESSION['upload_token'];
            //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            //header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }
        if (isset($_SESSION['upload_token']) && $_SESSION['upload_token']) {
            $client->setAccessToken($_SESSION['upload_token']);
            if ($client->isAccessTokenExpired()) {
                unset($_SESSION['upload_token']);
            }
        } else {
            $authUrl = $client->createAuthUrl();
            return $authUrl;
        }


    }

    public function getTheCalendarList()
    {
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);

        $client->setAccessToken($_SESSION['upload_token']);

        $calendars = $service->calendarList->listCalendarList();

        $calendarsArray = array();

        foreach ($calendars->getItems() as $calendar) {
             if ($calendar->getAccessRole() == 'owner') $calendarsArray[$calendar->getId()] = $calendar->getSummary();
        }
        return $calendarsArray;


    }

    public function addEvent($eventId, $calendarId)
    {
        session_start();

        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);

        $client->setAccessToken($_SESSION['upload_token']);


        $event = $this->eventRepository->read($eventId);

        $eventCreated = $service->events->quickAdd($calendarId, $event->thing->name);

        $eventCreated->setLocation(utf8_decode($event->eventLocation->postalAddress->streetAddress) . ", " . utf8_decode($event->eventLocation->thing->name));
        $data = array();
        $updatedEvent = $service->events->update($calendarId, $eventCreated->getId(), $eventCreated);
        //dd($updatedEvent->getLocation());
        /*
        if ( ! is_null($event->endDate)) $data['end']['datetime'] = $event->endDate;
        else $data['end'] = $result['end'];
        if ( ! is_null($event->startDate)) $data['start']['datetime'] = $event->startDate;
        else $data['start'] = $result['start'];

        if ( ! is_null($event->thing->url))
        {
            if ((strpos($event->thing->url, 'http://') !== false) or (strpos($event->thing->url, 'https://') !== false)) $data['source']['url'] = $event->thing->url;
            else $data['source']['url'] = 'http://' . $event->thing->url;
        }
        if ( ! is_null($event->thing->description)) $data['description'] = utf8_decode($event->thing->description);
        if ( ! is_null($event->location))
        {
            if ( ! is_null($event->eventLocation->address))
            {
                if ( ! is_null($event->eventLocation->postalAddress->streetAddress)) {
                    $data['location'] = utf8_decode($event->eventLocation->postalAddress->streetAddress) . ", " . utf8_decode($event->eventLocation->thing->name);
                }
            }
        }

        $this->updateAnEvent($calendarId, $eventId, $data);

        //dd("https://www.googleapis.com/calendar/v3/calendars/$calendarId/events/" . $result['id']);
        //dd($data);
        $result = json_decode( $this->googleService->request( "https://www.googleapis.com/calendar/v3/calendars/$calendarId/events/" . $result['id'], "PUT", $data ), true);
        dd($result);*/

    }


}