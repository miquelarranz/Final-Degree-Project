<?php namespace IntegrationSystem\core;

interface WriterInterface
{

    public function storeTheData($data, $configurationPathFile, $city);

}
