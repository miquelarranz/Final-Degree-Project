<?php namespace IntegrationSystem\writers;

use IntegrationSystem\core\WriterInterface;

class EventsWriter implements WriterInterface
{

    private $database = [
        'host'      => '127.0.0.1',
        'database'  => 'tfg',
        'username'  => 'root',
        'password'  => 'root'
    ];

    private $city;

    private $offersPendingToStore;

    private $organizationsPendingToStore;

    private $citiesPendingToStore;

    private $attributeFound;

    private function initializeTheObjectArrays()
    {
        $this->offersPendingToStore = array();
        $this->organizationsPendingToStore = array();
        $this->citiesPendingToStore = array();
    }

    public function storeTheData($data, $configurationFilePath, $city)
    {
        //dd($data);
        //Initializations of the object arrays
        $database = $this->connectToTheDatabase();

        $configurationFile = $this->getTheConfigurationFileContents($configurationFilePath);

        $this->city = $city;
        //First we need to look for the events inside the open data
        $events = $this->objectSearch(key($configurationFile), $data);
        if (is_null($events)) $events = $this->tagSearch(key($configurationFile), $data);

        foreach ($events as $event)
        {
            $this->initializeTheObjectArrays();
            $attributes = array();
            $className = "";
            foreach (current($configurationFile) as $configurationKey => $configurationValue)
            {
                if (is_array($configurationValue))
                {
                    $objectData = $this->objectSearch($configurationKey, $event);
                    //If it is null, the object attributes can be found in the event, they are not under an
                    //"array" structure.
                    if (is_null($objectData)) {
                        $tagData = $this->tagSearch($configurationKey, $event);
                        if ( ! is_null($tagData)) $this->objectProcessing($tagData, $configurationValue);
                        else $this->objectProcessing($event, $configurationValue);
                    }
                    else
                    {
                        foreach ($objectData as $objectElement)
                        {
                            $this->objectProcessing($objectElement, $configurationValue);
                        }
                    }
                }
                else
                {
                    $this->attributeFound = false;
                    $attributes[$configurationValue] = $this->attributeSearch($configurationKey, $event);
                }
            }

            //Once we have looked for all the objects of the data, we have to store them
            $locationId = null;

            foreach ($this->citiesPendingToStore as $city) $locationId = $this->storeInTheDatabase($city, 'locations', $database);

            $eventId = $this->storeInTheDatabase($attributes, 'events', $database, $locationId);

            foreach ($this->organizationsPendingToStore as $organization) $this->storeInTheDatabase($organization, 'organizations', $database, $eventId);

            foreach ($this->offersPendingToStore as $offer) $this->storeInTheDatabase($offer, 'offers', $database, $eventId);
        }
        mysqli_close($database);
    }

    private function objectSearch($object, $array)
    {
        //The position 0 is the name of the array key that we need to find. The position 1 is the "checksum",
        //that is a field name existing inside all the objects of the key. Will help us to solve the "one or many"
        //issue. The "checksum" value must exists in all the objects of the key
        $objectData = explode(":", $object);
        $return = null;
        //We check that the key has 2 values, else it is a tag search
        if (count($objectData) == 2)
        {
            foreach ($array as $key => $value)
            {
                if ($key === $objectData[0])
                {
                    //We need to check if the $value is the object or if it is an array of objects
                    if ($this->checkIfObject($objectData[1], current($value))) return $value;
                    else return current($value);
                } else
                {
                    if (is_array($value) and ! empty($value)) $return = $this->objectSearch($object, $value);
                }
            }
        }
        return $return;
    }

    private function checkIfObject($checksumField, $value)
    {
        //Returns true if the $value is an object and false if it is an array of objects
        if (is_array($value))
        {
            foreach ($value as $valueKey => $valueElement)
            {
                if ($valueKey === $checksumField) return true;
            }
            return false;
        }

        return true;
    }

    private function tagSearch($tag, $array)
    {
        $return = null;
        foreach ($array as $key => $value)
        {
            if ($key === $tag)
            {
                return $value;
            }
            else {
                if (is_array($value) and ! empty($value)) $return = $this->tagSearch($tag, $value);
            }
        }
        return $return;
    }

    private function attributeSearch($attribute, $array)
    {
        $return = null;
        foreach ($array as $key => $value)
        {
            if ( ! is_array($value))
            {
                if ($key === $attribute)
                {
                    $this->attributeFound = true;
                    return $value;
                }
            }
            else {
                if ( ! $this->attributeFound) $return = $this->attributeSearch($attribute, $value);
            }
        }
        return $return;
    }

    private function getTheConfigurationFileContents($configurationFilePath)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . $configurationFilePath;
        $file = file_get_contents($path, true);

        return json_decode($file, true);
    }

    private function connectToTheDatabase()
    {
        $database = new \mysqli($this->database['host'], $this->database['username'], $this->database['password'], $this->database['database']);

        if($database->connect_errno > 0){
            throw new \Exception('Unable to connect to database.');
        }

        return $database;
    }

    public function objectProcessing($data, $configurationFile)
    {
        $attributes = array();
        $className = null;

        foreach ($configurationFile as $configurationKey => $configurationValue)
        {
            if ($configurationKey === "class_name")
            {
                $className = $configurationValue;
            }
            else if ($configurationKey === "city_name")
            {
                $attributes[$configurationValue] = $this->city;
            }
            else
            {
                $this->attributeFound = false;
                $attributes[$configurationValue] = $this->attributeSearch($configurationKey, $data);
            }
        }
        //TODO: si no hay class_name pum
        if ($className == 'offers') $this->offersPendingToStore[] = $attributes;
        if ($className == 'organizations') $this->organizationsPendingToStore[] = $attributes;
        if ($className == 'locations') $this->citiesPendingToStore[] = $attributes;
    }

    public function storeInTheDatabase($attributes, $name, $database, $identifier = null)
    {
        if ($name == 'organizations') $this->storeAnOrganization($attributes, $database, $identifier);
        else if ($name == 'offers') $this->storeAnOffer($attributes, $database, $identifier);
        else if ($name == 'locations') $identifier = $this->storeACity($attributes, $database);
        else if ($name == 'events') $identifier = $this->storeAnEvent($attributes, $database, $identifier);

        return $identifier;
    }

    public function storeAnOrganization($attributes, $database, $identifier)
    {
        $thingQuery = "INSERT INTO things (id";
        $organizationQuery = "INSERT INTO organizations (id, event";
        $thingValues = "NULL";
        $organizationValues = ", $identifier";

        foreach ($attributes as $information => $value)
        {
            $attributeInformation = explode(":", $information);
            if ($attributeInformation[0] == "things")
            {
                $thingQuery = $thingQuery . ', ' . $attributeInformation[1];
                if (is_null($value)) $thingValues = $thingValues . ", NULL";
                else $thingValues = $thingValues . ", '" . str_replace("'", "\'", $value) . "'";
            }
            else if ($attributeInformation[0] == "organizations")
            {
                $organizationQuery = $organizationQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $organizationValues = $organizationValues . ", NULL";
                else $organizationValues = $organizationValues . ", '" . str_replace("'", "\'", $value) . "'";
            }

        }
        $thingQuery = $thingQuery . ") VALUES (" . $thingValues . ");";
        mysqli_query($database, $thingQuery);
        $organizationQuery = $organizationQuery . ") VALUES (" . $database->insert_id . $organizationValues . ");";
        mysqli_query($database, $organizationQuery);
    }

    public function storeAnOffer($attributes, $database, $identifier)
    {
        $thingQuery = "INSERT INTO things (id";
        $intangibleQuery = "INSERT INTO intangibles (id";
        $offerQuery = "INSERT INTO offers (id, event";
        $thingValues = "NULL";
        $intangibleValues = "";
        $offerValues = ", $identifier";

        foreach ($attributes as $information => $value)
        {
            $attributeInformation = explode(":", $information);
            if ($attributeInformation[0] == "things")
            {
                $thingQuery = $thingQuery . ', ' . $attributeInformation[1];
                if (is_null($value)) $thingValues = $thingValues . ", NULL";
                else $thingValues = $thingValues . ", '" . str_replace("'", "\'", $value) . "'";
            }
            else if ($attributeInformation[0] == "intangibles")
            {
                $intangibleQuery = $intangibleQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $intangibleValues = $intangibleValues . ", NULL";
                else $intangibleValues = $intangibleValues . ", '" . str_replace("'", "\'", $value) . "'";
            }
            else if ($attributeInformation[0] == "offers")
            {
                $offerQuery = $offerQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $offerValues = $offerValues . ", NULL";
                else $offerValues = $offerValues . ", '" . str_replace("'", "\'", $value) . "'";
            }

        }
        $thingQuery = $thingQuery . ") VALUES (" . $thingValues . ");";
        mysqli_query($database, $thingQuery);

        $thingId = $database->insert_id;

        $intangibleQuery = $intangibleQuery . ") VALUES (" . $thingId . $intangibleValues . ");";
        mysqli_query($database, $intangibleQuery);

        $offerQuery = $offerQuery . ") VALUES (" . $thingId . $offerValues . ");";
        mysqli_query($database, $offerQuery);
    }

    public function storeACity($attributes, $database)
    {
        $insertAPostalAddress = false;
        $insertAGeoCoordinates = false;

        $thingQuery = "INSERT INTO things (id";
        $placeQuery = "INSERT INTO places (id, geo, address";
        $postalAddressThingQuery = "INSERT INTO things (id";
        $geoCoordinateThingQuery = "INSERT INTO things (id";
        $geoCoordinateQuery = "INSERT INTO geoCoordinates (id";
        $postalAddressQuery = "INSERT INTO postalAddresses (id";

        $thingValues = "NULL";
        $postalAddressThingValues = "NULL";
        $geoCoordinatesThingValues = "NULL";
        $placeValues = "";
        $geoCoordinateValues = "";
        $postalAddressValues = "";

        foreach ($attributes as $information => $value)
        {
            $attributeInformation = explode(":", $information);
            if ($attributeInformation[0] == "things")
            {
                $thingQuery = $thingQuery . ', ' . $attributeInformation[1];
                if (is_null($value)) $thingValues = $thingValues . ", NULL";
                else $thingValues = $thingValues . ", '" . $value . "'";
            }
            else if ($attributeInformation[0] == "postalAddressThings")
            {
                $postalAddressThingQuery = $postalAddressThingQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $postalAddressThingValues = $postalAddressThingValues . ", NULL";
                else $postalAddressThingValues = $postalAddressThingValues . ", '" . str_replace("'", "\'", $value) . "'";
                $insertAPostalAddress = true;
            }
            else if ($attributeInformation[0] == "geoCoordinateThings")
            {
                $geoCoordinateThingQuery = $geoCoordinateThingQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $geoCoordinatesThingValues = $geoCoordinatesThingValues . ", NULL";
                else $geoCoordinatesThingValues = $geoCoordinatesThingValues . ", '" . str_replace("'", "\'", $value) . "'";
                $insertAGeoCoordinates = true;
            }
            else if ($attributeInformation[0] == "places")
            {
                $placeQuery = $placeQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $placeValues = $placeValues . ", NULL";
                else $placeValues = $placeValues . ", '" . str_replace("'", "\'", $value) . "'";
            }
            else if ($attributeInformation[0] == "geoCoordinates")
            {
                $geoCoordinateQuery = $geoCoordinateQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $geoCoordinateValues = $geoCoordinateValues . ", NULL";
                else $geoCoordinateValues = $geoCoordinateValues . ", '" . str_replace("'", "\'", $value) . "'";
                $insertAGeoCoordinates = true;
            }
            else if ($attributeInformation[0] == "postalAddresses")
            {
                $postalAddressQuery = $postalAddressQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $postalAddressValues = $postalAddressValues . ", NULL";
                else $postalAddressValues = $postalAddressValues . ", '" . str_replace("'", "\'", $value) . "'";
                $insertAPostalAddress = true;
            }

        }

        $geoCoordinatesId = "NULL";
        $postalAddressId = "NULL";

        if ($insertAGeoCoordinates)
        {
            $geoCoordinateThingQuery = $geoCoordinateThingQuery . ") VALUES (" . $geoCoordinatesThingValues . ");";
            mysqli_query($database, $geoCoordinateThingQuery);

            $geoCoordinatesId = $database->insert_id;

            mysqli_query($database, "INSERT INTO intangibles (id) VALUES ($geoCoordinatesId);");
            mysqli_query($database, "INSERT INTO structuredValues (id) VALUES ($geoCoordinatesId);");

            $geoCoordinateQuery = $geoCoordinateQuery . ") VALUES (" . $geoCoordinatesId . $geoCoordinateValues . ");";
            mysqli_query($database, $geoCoordinateQuery);
        }

        if ($insertAPostalAddress)
        {
            $postalAddressThingQuery = $postalAddressThingQuery . ") VALUES (" . $postalAddressThingValues . ");";
            mysqli_query($database, $postalAddressThingQuery);

            $postalAddressId = $database->insert_id;

            mysqli_query($database, "INSERT INTO intangibles (id) VALUES ($postalAddressId);");

            mysqli_query($database, "INSERT INTO structuredValues (id) VALUES ($postalAddressId);");
            mysqli_query($database, "INSERT INTO contactPoints (id) VALUES ($postalAddressId);");

            $postalAddressQuery = $postalAddressQuery . ") VALUES (" . $postalAddressId . $postalAddressValues . ");";
            mysqli_query($database, $postalAddressQuery);
        }

        $thingQuery = $thingQuery . ") VALUES (" . $thingValues . ");";
        mysqli_query($database, $thingQuery);
        //var_dump($database->error);

        $thingId = $database->insert_id;

        $placeQuery = $placeQuery . ") VALUES (" . $thingId . ", $geoCoordinatesId, $postalAddressId" . $placeValues . ");";
        mysqli_query($database, $placeQuery);
        //var_dump($database->error);

        mysqli_query($database, "INSERT INTO administrativeAreas (id) VALUES ($thingId);");
        mysqli_query($database, "INSERT INTO cities (id) VALUES ($thingId);");

        return $thingId;
    }

    public function storeAnEvent($attributes, $database, $identifier)
    {
        $thingQuery = "INSERT INTO things (id";
        $eventQuery = "INSERT INTO events (id, location";
        $thingValues = "NULL";
        if (is_null($identifier)) $eventValues = ", NULL";
        else $eventValues = ", $identifier";

        foreach ($attributes as $information => $value)
        {
            $attributeInformation = explode(":", $information);
            if ($attributeInformation[0] == "things")
            {
                $thingQuery = $thingQuery . ', ' . $attributeInformation[1];
                if (is_null($value)) $thingValues = $thingValues . ", NULL";
                else $thingValues = $thingValues . ", '" . str_replace("'", "\'", $value) . "'";
            }
            else if ($attributeInformation[0] == "events")
            {
                $eventQuery = $eventQuery . ", " . $attributeInformation[1];
                //If the value has to be a date/datime, its necessary to do this
                if ($attributeInformation[1] == "startDate" or $attributeInformation[1] == "endDate" or $attributeInformation[1] == "doorTime")
                {
                    //We do not know the format of the date, so we have to try different formats
                    $value = $this->getTheRightDate($value);
                }
                if ($attributeInformation[1] == "duration") $value = new \Time($value);
                if (is_null($value)) $eventValues = $eventValues . ", NULL";
                else $eventValues = $eventValues . ", '" . str_replace("'", "\'", $value) . "'";
            }

        }

        $thingQuery = $thingQuery . ") VALUES (" . $thingValues . ");";

        mysqli_query($database, $thingQuery);
        $thingId = $database->insert_id;

        $eventQuery = $eventQuery . ") VALUES (" . $thingId  . $eventValues . ");";

        mysqli_query($database, $eventQuery);
        if($database->error != "") dd($database->error);

        return $thingId;
    }

    private function getTheRightDate($value)
    {
        $date = \DateTime::createFromFormat('d-m-Y H:i:s', $value);
        if ( ! $date) {
            $date = \DateTime::createFromFormat('d-m-Y', $value);
            if ($date) $date->setTime(0,0,0);
        }
        if ( ! $date) $date = \DateTime::createFromFormat('m-d-Y H:i:s', $value);
        if ( ! $date) {
            $date = \DateTime::createFromFormat('m-d-Y', $value);
            if ($date) $date->setTime(0,0,0);
        }
        if ( ! $date) $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
        if ( ! $date) {
            $date = \DateTime::createFromFormat('Y-m-d', $value);
            if ($date) $date->setTime(0,0,0);
        }
        if ( ! $date) $date = \DateTime::createFromFormat('d/m/Y H:i:s', $value);
        if ( ! $date) {
            $date = \DateTime::createFromFormat('d/m/Y', $value);
            if ($date) $date->setTime(0,0,0);
        }
        if ( ! $date) $date = \DateTime::createFromFormat('m/d/Y H:i:s', $value);
        if ( ! $date) {
            $date = \DateTime::createFromFormat('m/d/Y', $value);
            if ($date) $date->setTime(0,0,0);
        }
        if ( ! $date) $date = \DateTime::createFromFormat('Y/m/d H:i:s', $value);
        if ( ! $date) {
            $date = \DateTime::createFromFormat('Y/m/d', $value);
            if ($date) $date->setTime(0,0,0);
        }
        if ( ! $date) $date = \DateTime::createFromFormat('Y-m-d\TH:i:s', $value);

        if ( ! $date) return null;

        return $date->format('Y/m/d H:i:s');
    }
}