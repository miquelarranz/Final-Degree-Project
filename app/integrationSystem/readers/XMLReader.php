<?php namespace IntegrationSystem\readers;

use Exception;
use IntegrationSystem\core\ReaderInterface;

class XMLReader implements ReaderInterface
{
    public function readFromAnURL($url)
    {
        /*try {
            $ch = curl_init();

            if (FALSE === $ch) throw new Exception('failed to initialize');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_URL, $url);

            $data = curl_exec($ch);

            if (FALSE === $data)
                throw new Exception(curl_error($ch), curl_errno($ch));

            curl_close($ch);

        } catch(Exception $e) {

            trigger_error(sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }*/
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