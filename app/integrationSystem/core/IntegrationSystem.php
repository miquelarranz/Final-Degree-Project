<?php namespace IntegrationSystem\core;

use IntegrationSystem\readers\JSONReader;
use IntegrationSystem\readers\XMLReader;
use IntegrationSystem\writers\EventsWriter;
use ReflectionClass;

class IntegrationSystem
{
    private $JSONReader;

    private $XMLReader;

    private $eventsWriter;

    function __construct(JSONReader $JSONReader, XMLReader $XMLReader, EventsWriter $eventsWriter)
    {
        $this->JSONReader = $JSONReader;
        $this->XMLReader = $XMLReader;
        $this->eventsWriter = $eventsWriter;
    }


    public function integrateAnOpenDataSource($url, $extension)
    {

        $reader = $this->findTheReader($extension);

        if ( ! $reader) throw new \Exception("The extension is not compatible with the integration system.");

        $data = $reader->readFromAnURL($url);

        //TODO: check the errors thrown
        if (empty($data)) throw new \Exception("The file is empty or wrong.");

        $dataArray = $reader->toArray($data);

        $city = 'Barcelona';
        $configurationFilePath = '/files/Configuration.json';

        $this->eventsWriter->storeTheData($dataArray, $configurationFilePath, $city);
    }

    private function findTheReader($extension)
    {
        $reader = null;
        foreach (get_object_vars($this) as $variable)
        {
            $classNameWithNamespace = get_class($variable);
            $class = new ReflectionClass($classNameWithNamespace);
            $className = $class->getShortName();
            if (str_replace($extension, "", $className) == 'Reader') $reader = $variable;
        }

        return $reader;
    }

}
