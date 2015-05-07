<?php namespace IntegrationSystem\readers;

use IntegrationSystem\core\ReaderInterface;

class JSONReader implements ReaderInterface
{
    public function readFromAnURL($url)
    {
        header('Content-Type: text/html; charset=utf-8');
        return file_get_contents($url);
    }

    public function toArray($data)
    {
        return json_decode($data, true);
    }
}