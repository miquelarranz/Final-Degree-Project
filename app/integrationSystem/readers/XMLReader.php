<?php namespace IntegrationSystem\readers;

use IntegrationSystem\core\ReaderInterface;

class JSONReader implements ReaderInterface
{
    public function readFromAnURL($url)
    {
        return file_get_contents($url);
        ;
    }

    public function toArray($data)
    {
        return json_decode($data, true);
    }
}