<?php namespace IntegrationSystem\readers;

use IntegrationSystem\core\ReaderInterface;

class JSONReader implements ReaderInterface
{
    public function readFromAnURL($url)
    {
        dd(file_get_contents($url));
    }

    public function toArray($data)
    {
        // TODO: Implement toArray() method.
    }
}