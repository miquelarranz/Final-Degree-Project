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

    public function storeTheData($data, $configurationFilePath, $city)
    {
        $database = $this->connectToTheDatabase();

        $configurationFile = $this->getTheConfigurationFileContents($configurationFilePath);

        //dd(current($configurationFile));
        //$configuration = current($configurationFile);
        //$class_name = $configuration['class_name'];

        //First we need to look for the events inside the open data
        $events = $this->objectSearch(key($configurationFile), $data);

        foreach ($events as $event)
        {
            $attributes = array();

            foreach (current($configurationFile) as $configurationKey => $configurationValue)
            {
                if (is_array($configurationValue)) //class
                {
                    $classData = $this->objectSearch($configurationKey, $event);
                    foreach ($classData as $classElement)
                    {
                        $this->classProcessing($classData, $configurationValue, $database);
                    }
                }
                else //attribute
                {
                    //dd($configurationValue);
                    //dd($this->attributeSearch($configurationKey, $event));
                    //dd($event);
                    $attributes[$configurationValue] = $this->attributeSearch($configurationKey, $event);
                }
            }
            $this->storeInTheDatabase($attributes, 'events', $database);
        }
        mysqli_close($database);
        dd('done');
    }

    private function objectSearch($object, $array)
    {
        $return = null;
        foreach ($array as $key => $value)
        {
            if ($key === $object)
            {
                return $value;
            }
            else {
                if (is_array($value)) $return = $this->objectSearch($object, $value);
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
                    return $value;
                }
            }
            else {
                $return = $this->objectSearch($attribute, $value);
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

    public function classProcessing($data, $configurationFile, $database)
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
            //dd($configurationValue);
            //dd($this->attributeSearch($configurationKey, $data));
            //dd($data);
        }
        //TODO: si no hay class_name pum
        $this->storeInTheDatabase($attributes, $className, $database);
    }

    public function storeInTheDatabase($attributes, $name, $database)
    {
        if ($name == 'organizations') $this->storeAnOrganization($attributes, $database);
        else if ($name == 'offers') $this->storeAnOffer($attributes, $database);
        else if ($name == 'location') $this->storeACity($attributes, $database);
        else if ($name == 'events') $this->storeAnEvent($attributes, $database);
    }

    public function storeAnOrganization($attributes, $database)
    {
        $thingQuery = "INSERT INTO things (id";
        $organizationQuery = "INSERT INTO organizations (id";
        $thingValues = "null";
        $organizationValues = "";

        foreach ($attributes as $information => $value)
        {
            $attributeInformation = explode(":", $information);
            if ($attributeInformation[0] == "things")
            {
                $thingQuery = $thingQuery . ', ' . $attributeInformation[1];
                $thingValues = $thingValues . ", '" . $value . "'";
            }
            else if ($attributeInformation[0] == "organizations")
            {
                $organizationQuery = $organizationQuery . ", " . $attributeInformation[1];
                $organizationValues = $organizationValues . ", '" . $value . "'";
            }

        }
        $thingQuery = $thingQuery . ") VALUES (" . $thingValues . ");";
        mysqli_query($database, $thingQuery);
        $organizationQuery = $organizationQuery . ") VALUES (" . $database->insert_id . $organizationValues . ");";
        mysqli_query($database, $organizationQuery);
    }

    public function storeAnOffer($attributes, $database)
    {

    }

    public function storeACity($attributes, $database)
    {

    }

    public function storeAnEvent($attributes, $database)
    {
        $thingQuery = "INSERT INTO things (id";
        $eventQuery = "INSERT INTO `events` (id";
        $thingValues = "null";
        $eventValues = "";

        foreach ($attributes as $information => $value)
        {
            $attributeInformation = explode(":", $information);
            if ($attributeInformation[0] == "things")
            {
                $thingQuery = $thingQuery . ', ' . $attributeInformation[1];
                $thingValues = $thingValues . ", '" . $value . "'";
            }
            else if ($attributeInformation[0] == "organizations")
            {
                $eventQuery = $eventQuery . ", " . $attributeInformation[1];
                $eventValues = $eventValues . ", '" . $value . "'";
            }

        }

        $thingQuery = $thingQuery . ") VALUES (" . $thingValues . ");";
        mysqli_query($database, $thingQuery);
        $eventQuery = $eventQuery . ") VALUES (" . $database->insert_id . $eventValues . ");";

        mysqli_query($database, $eventQuery);
    }
}