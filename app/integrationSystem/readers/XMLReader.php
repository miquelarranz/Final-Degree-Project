<?php namespace IntegrationSystem\readers;

use IntegrationSystem\core\ReaderInterface;

class XMLReader implements ReaderInterface
{
    public function readFromAnURL($url)
    {
        header('Content-Type: text/html; charset=utf-8');
        $data = file_get_contents($url);
        $xml = simplexml_load_string($data);

        return json_encode($xml);
    }

    public function toArray($data)
    {
        return json_decode($data, true);
    }
}