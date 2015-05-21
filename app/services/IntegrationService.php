<?php namespace services;

use IntegrationSystem\core\IntegrationSystem;
use repositories\AdministrativeAreaRepository;
use repositories\CityRepository;
use repositories\ContactPointRepository;
use repositories\EventRepository;
use repositories\GeoCoordinatesRepository;
use repositories\IntangibleRepository;
use repositories\OfferRepository;
use repositories\OpenDataCityRepository;
use repositories\OpenDataSourceRepository;
use repositories\OrganizationRepository;
use repositories\PlaceRepository;
use repositories\PostalAddressRepository;
use repositories\StructuredValueRepository;
use repositories\ThingRepository;

class IntegrationService {

    protected $integrationSystem;

    private $thingRepository;

    private $intangibleRepository;

    private $offerRepository;

    private $organizationRepository;

    private $eventRepository;

    private $cityRepository;

    private $administrativeAreaRepository;

    private $placeRepository;

    private $postalAddressRepository;

    private $contactPointRepository;

    private $structuredValueRepository;

    private $geoCoordinatesRepository;

    private $openDataCityRepository;

    private $openDataSourceRepository;

    public function __construct(IntegrationSystem $integrationSystem, ThingRepository $thingRepository, IntangibleRepository $intangibleRepository, OfferRepository $offerRepository, OrganizationRepository $organizationRepository, EventRepository $eventRepository, CityRepository $cityRepository, AdministrativeAreaRepository $administrativeAreaRepository, PlaceRepository $placeRepository, PostalAddressRepository $postalAddressRepository, ContactPointRepository $contactPointRepository, StructuredValueRepository $structuredValueRepository, GeoCoordinatesRepository $geoCoordinatesRepository, OpenDataCityRepository $openDataCityRepository, OpenDataSourceRepository $openDataSourceRepository)
    {
        $this->integrationSystem = $integrationSystem;
        $this->thingRepository = $thingRepository;
        $this->intangibleRepository = $intangibleRepository;
        $this->offerRepository = $offerRepository;
        $this->organizationRepository = $organizationRepository;
        $this->eventRepository = $eventRepository;
        $this->cityRepository = $cityRepository;
        $this->administrativeAreaRepository = $administrativeAreaRepository;
        $this->placeRepository = $placeRepository;
        $this->postalAddressRepository = $postalAddressRepository;
        $this->contactPointRepository = $contactPointRepository;
        $this->structuredValueRepository = $structuredValueRepository;
        $this->geoCoordinatesRepository = $geoCoordinatesRepository;
        $this->openDataCityRepository = $openDataCityRepository;
        $this->openDataSourceRepository = $openDataSourceRepository;
    }

    public function integrateAnOpenDataSource($source)
    {
        $this->integrationSystem->integrateAnOpenDataSource($source->url, $source->extension, utf8_decode($source->relatedCity->name), $source->configurationFilePath);
    }

    public function cleanAllTheEvents()
    {
        $events = $this->eventRepository->all(array('clean' => 'clean'));

        foreach($events as $event)
        {
            foreach ($event->offers as $offer)
            {
                $offerId = $offer->id;
                $this->offerRepository->delete($offerId);
                $this->intangibleRepository->delete($offerId);
                $this->thingRepository->delete($offerId);
            }
            foreach ($event->performers as $performer)
            {
                $performerId = $performer->id;
                $this->organizationRepository->delete($performerId);
                $this->thingRepository->delete($performerId);
            }

            $place = null;
            $placeId = null;
            $postalAddressId = null;
            $geoCoordinatesId = null;

            if ( ! is_null($event->eventLocation))
            {
                $place = $event->eventLocation;
                $placeId = $place->id;
            }
            $eventId = $event->id;

            if ( ! is_null($place))
            {
                if ( ! is_null($place->geoCoordinates)) $geoCoordinatesId = $place->geoCoordinates->id;
                if ( ! is_null($place->postalAddress)) $postalAddressId = $place->postalAddress->id;
                //var_dump($postalAddressId);
            }

            $this->eventRepository->delete($eventId);
            $this->thingRepository->delete($eventId);

            if ( ! is_null($placeId))
            {
                $this->cityRepository->delete($placeId);
                $this->administrativeAreaRepository->delete($placeId);
                $this->placeRepository->delete($placeId);
                $this->thingRepository->delete($placeId);
            }
            if ( ! is_null($postalAddressId))
            {
                //var_dump($postalAddressId);
                $this->postalAddressRepository->delete($postalAddressId);
                $this->contactPointRepository->delete($postalAddressId);
                $this->structuredValueRepository->delete($postalAddressId);
                $this->intangibleRepository->delete($postalAddressId);
                $this->thingRepository->delete($postalAddressId);
            }
            if ( ! is_null($geoCoordinatesId))
            {
                $this->geoCoordinatesRepository->delete($geoCoordinatesId);
                $this->structuredValueRepository->delete($geoCoordinatesId);
                $this->intangibleRepository->delete($geoCoordinatesId);
                $this->thingRepository->delete($geoCoordinatesId);
            }
        }
    }

    public function updateAllTheSources()
    {
        $openDataSources = $this->openDataSourceRepository->all();

        foreach ($openDataSources as $openDataSource)
        {
            $this->integrateAnOpenDataSource($openDataSource);

            $date = new \DateTime();
            $this->openDataSourceRepository->update(array('id' => $openDataSource->id, 'lastUpdateDate' => $date->format('Y-m-d H:i:s')));
        }
    }
}