<?php namespace IntegrationSystem\writers;

use IntegrationSystem\core\WriterInterface;

class EventsWriter implements WriterInterface
{
    public function storeTheData($data, $configurationFilePath, $city)
    {

        $configurationFile = $this->getTheConfigurationFileContents($configurationFilePath);
        dd($configurationFile);



        //dd(yaml_parse($configurationFilePath));
        //dd($this->objectSearch("performers", $data));
        //dd($this->attributeSearch("announce_date", $data));

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
                if ($value === $attribute)
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
}