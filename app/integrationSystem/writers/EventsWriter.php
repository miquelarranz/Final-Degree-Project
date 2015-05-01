<?php namespace IntegrationSystem\writers;

use IntegrationSystem\core\WriterInterface;

class EventsWriter implements WriterInterface
{

    private $database = [
        'host'      => '127.0.0.1',
        'database'  => 'tfg',
        'username'  => 'root',
        'password'  => ''
    ];

    private $offersPendingToStore;

    private $organizationsPendingToStore;

    private $citiesPendingToStore;

    private function initializeTheObjectArrays()
    {
        $this->offersPendingToStore = array();
        $this->organizationsPendingToStore = array();
        $this->citiesPendingToStore = array();
    }

    public function storeTheData($data, $configurationFilePath, $city)
    {
        //Initializations of the object arrays
        $database = $this->connectToTheDatabase();

        $configurationFile = $this->getTheConfigurationFileContents($configurationFilePath);

        //First we need to look for the events inside the open data
        $events = $this->objectSearch(key($configurationFile), $data);
        //dd($events);
        //dd($events);
        foreach ($events as $event)
        {
            $this->initializeTheObjectArrays();

            $attributes = array();
            foreach (current($configurationFile) as $configurationKey => $configurationValue)
            {
                if (is_array($configurationValue))
                {
                    //var_dump($configurationValue);
                    $objectData = $this->objectSearch($configurationKey, $event);
                    //If it is null, the object attributes can be found in the event, they are not under an
                    //"array" structure.
                    if (is_null($objectData)) {
                        $this->objectProcessing($event, $configurationValue);
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
        dd('done');
    }

    private function objectSearch($object, $array)
    {
        //The position 0 is the name of the array key that we need to find. The position 1 is the "checksum",
        //that is a field name existing inside all the objects of the key. Will help us to solve the "one or many"
        //issue. The "checksum" value must exists in all the objects of the key
        $objectData = explode(":", $object);
        $return = null;
        foreach ($array as $key => $value)
        {
            if ($key === $objectData[0])
            {
                //We need to check if the $value is the object or if it is an array of objects
                //dd($value);
                if ($this->checkIfObject($objectData[1], current($value))) return $value;
                else return current($value);
            }
            else {
                if (is_array($value)) $return = $this->objectSearch($object, $value);
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

    private function attributeSearch($attribute, $array)
    {
        $return = null;
        foreach ($array as $key => $value)
        {
            if ( ! is_array($value))
            {
                if ($key === $attribute)
                {
                    return $value;
                }
            }
            else {
                $return = $this->attributeSearch($attribute, $value);
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
            if ($configurationKey == "class_name")
            {
                $className = $configurationValue;
            }
            else
            {
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
        else if ($name == 'locations') $this->storeACity($attributes, $database);
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
                $thingValues = $thingValues . ", '" . $value . "'";
            }
            else if ($attributeInformation[0] == "organizations")
            {
                $organizationQuery = $organizationQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $organizationValues = $organizationValues . ", NULL";
                $organizationValues = $organizationValues . ", '" . $value . "'";
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
                $thingValues = $thingValues . ", '" . $value . "'";
            }
            else if ($attributeInformation[0] == "intangibles")
            {
                $intangibleQuery = $intangibleQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $intangibleValues = $intangibleValues . ", NULL";
                $intangibleValues = $intangibleValues . ", '" . $value . "'";
            }
            else if ($attributeInformation[0] == "offers")
            {
                $offerQuery = $offerQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $offerValues = $offerValues . ", NULL";
                else $offerValues = $offerValues . ", '" . $value . "'";
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
                $thingValues = $thingValues . ", '" . $value . "'";
            }
            else if ($attributeInformation[0] == "organizations")
            {
                $eventQuery = $eventQuery . ", " . $attributeInformation[1];
                if (is_null($value)) $eventValues = $eventValues . ", NULL";
                $eventValues = $eventValues . ", '" . $value . "'";
            }

        }

        $thingQuery = $thingQuery . ") VALUES (" . $thingValues . ");";
        mysqli_query($database, $thingQuery);

        $thingId = $database->insert_id;
        $eventQuery = $eventQuery . ") VALUES (" . $thingId  . $eventValues . ");";
        mysqli_query($database, $eventQuery);

        return $thingId;
    }
}