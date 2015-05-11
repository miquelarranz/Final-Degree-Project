<?php namespace services;

use Google_Client;
use Google_Service_Calendar_EventSource;
use Illuminate\Support\Facades\Session;
use repositories\EventRepository;

class GoogleService {
    
    private $eventRepository;

    function __construct(EventRepository $eventRepository)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . '/path/to/google-api-php-client/src');

        $this->eventRepository = $eventRepository;
    }

    /*public function login2($code)
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
    }*/

    /*public function getTheCalendarList2()
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

    }*/

    private function getClient()
    {
        $client = new Google_Client();
        $client->setClientId('781414786878-cl3bd8ctkn2ocbpiikph7bo8mhgl8jjb.apps.googleusercontent.com');
        $client->setClientSecret('BfOUsUkBDfguxCMPBLXlcv7y');
        $client->setRedirectUri('http://localhost:8000/login/google/');
        $client->setScopes('https://www.googleapis.com/auth/calendar');
        $client->setAccessType("online");
        $client-> setApprovalPrompt("auto");

        return $client;
    }

    public function login()
    {
        $client = $this->getClient();

        $service = new \Google_Service_Calendar($client);

        /* Si el token expira, s'ha de tornar a autenticar */

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            Session::put('upload_token', $client->getAccessToken());
        }
        if (Session::has('upload_token') && Session::get('upload_token')) {
            $client->setAccessToken(Session::get('upload_token'));
            if($client->isAccessTokenExpired()) {
                Session::forget('upload_token');
                $authUrl = $client->createAuthUrl();
                header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
                return $authUrl;
            }
            return null;
        } else {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            return $authUrl;
        }
    }

    public function getTheCalendarList()
    {
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);
        $client->setAccessToken(Session::get('upload_token'));

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

        $client->setAccessToken(Session::get('upload_token'));


        $event = $this->eventRepository->read($eventId);

        $eventCreated = $service->events->quickAdd($calendarId, $event->thing->name);

        if ( ! is_null($event->startDate))
        {
            $start = new \DateTime($event->startDate);
            $eventCreated->getStart()->setDateTime($start->format('Y-m-d\TH:i:sP'));
        }
        if ( ! is_null($event->endDate))
        {
            $end = new \DateTime($event->endDate);
            $eventCreated->getEnd()->setDateTime($end->format('Y-m-d\TH:i:sP'));
        }

        if ( ! is_null($event->thing->url))
        {
            $source = new Google_Service_Calendar_EventSource();

            if ((strpos($event->thing->url, 'http://') !== false) or (strpos($event->thing->url, 'https://') !== false)) $source->setUrl($event->thing->url);
            else $source->setUrl('http://' . $event->thing->url);

            $eventCreated->setSource($source);
        }
        if ( ! is_null($event->thing->description)) $eventCreated->setDescription(utf8_decode($event->thing->description));
        if ( ! is_null($event->location))
        {
            if ( ! is_null($event->eventLocation->address))
            {
                if ( ! is_null($event->eventLocation->postalAddress->streetAddress)) {
                    $eventCreated->setLocation(utf8_decode($event->eventLocation->postalAddress->streetAddress) . ", " . utf8_decode($event->eventLocation->thing->name));
                }
            }
        }

        $updatedEvent = $service->events->update($calendarId, $eventCreated->getId(), $eventCreated);
    }
    
}