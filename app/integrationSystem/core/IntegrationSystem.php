<?php namespace IntegrationSystem\core;

interface ReaderInterface
{

    public function readFromAnURL($url);

    public function toArray($data);

}
