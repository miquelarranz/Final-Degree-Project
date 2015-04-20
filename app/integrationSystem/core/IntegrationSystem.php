<?php namespace IntegrationSystem\core;

use IntegrationSystem\readers\JSONReader;
use IntegrationSystem\readers\XMLReader;
use ReflectionClass;

class IntegrationSystem
{
    private $JSONReader;

    private $XMLReader;

    function __construct(JSONReader $JSONReader, XMLReader $XMLReader)
    {
        $this->JSONReader = $JSONReader;

        $this->XMLReader = $XMLReader;
    }


    public function integrateAnOpenDataSource($url, $extension)
    {

        $reader = $this->findTheReader($extension);

        if ( ! $reader) throw new \Exception("The extension is not compatible with the integration system.");

        $data = $reader->readFromAnURL($url);

        if (empty($data)) throw new \Exception("The file is empty or wrong.");

        $dataArray = $reader->toArray($data);

        dd($dataArray);

        return $dataArray;
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
