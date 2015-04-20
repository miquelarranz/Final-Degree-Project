<?php

use IntegrationSystem\readers\JSONReader;
use IntegrationSystem\readers\XMLReader;

class IntegrationController extends \BaseController {

    //Cal fer un servei

    public function reader()
    {
        $reader = new XMLReader();
        //$reader = new JSONReader();
        //JSON: http://api.seatgeek.com/2/events?venue.city=NY&per_page=200
        //XML: http://opendata.bcn.cat/opendata/es/descarrega-fitxer?url=http%3a%2f%2fdades.eicub.net%2fapi%2f1%2ffestivals-assistents%3fformat%3dxml&name=festivals-assistents.xml&transfer=y
        $data = $reader->readFromAnURL('http://datos.madrid.es/portal/site/egob/menuitem.ac61933d6ee3c31cae77ae7784f1a5a0/?vgnextoid=00149033f2201410VgnVCM100000171f5a0aRCRD&format=xml&file=0&filename=206974-0-agenda-eventos-culturales-100&mgmtid=6c0b6d01df986410VgnVCM2000000c205a0aRCRD');
        //$data = $reader->readFromAnURL('http://api.seatgeek.com/2/events?venue.city=NY&per_page=200');
        $array = $reader->toArray($data);
        dd($this->utf8_converter($array));
    }

    private function utf8_converter($array)
    {
        var_dump('loco');
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
            }
        });

        return $array;
    }
}
