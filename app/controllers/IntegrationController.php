<?php

use services\IntegrationService;

class IntegrationController extends \BaseController {

    private $integrationService;

    public function __construct(IntegrationService $integrationService)
    {
        $this->integrationService = $integrationService;
    }

    public function reader()
    {
        //OK
        $url = 'http://api.seatgeek.com/2/events?venue.city=NY&per_page=50&format=xml';
        $url = 'http://datos.madrid.es/portal/site/egob/menuitem.ac61933d6ee3c31cae77ae7784f1a5a0/?vgnextoid=00149033f2201410VgnVCM100000171f5a0aRCRD&format=xml&file=0&filename=206974-0-agenda-eventos-culturales-100&mgmtid=6c0b6d01df986410VgnVCM2000000c205a0aRCRD';
        $url = 'http://www.zaragoza.es/buscador/select?q=*:*%20AND%20-tipocontenido_s:estatico%20AND%20category:Actividades&rows=200';
        $url = 'http://datos.gijon.es/doc/cultura-ocio/centro-lectura.xml';
        $url = 'http://datos.alcobendas.org/dataset/2458d605-1fd0-4d16-a1ef-795bc243e152/resource/96860600-1b5b-46f4-841b-53ffcf78711e/download/agendacultural.json';
        $url = 'http://www.nycgovparks.org/xml/events_300_rss.xml';
        //OK Gijon
        //$url = 'http://datos.gijon.es/doc/cultura-ocio/sala-exposiciones.xml';
        //OK BCN esports
        $url = 'http://w10.bcn.es/APPS/asiasiacache/peticioXmlAsia?id=203';
        //$url = 'http://www.nanaimo.ca/PRC/CulturalMap/odata/Entities';
        //OK
        //$url = 'http://api.seatgeek.com/2/events?venue.city=NY&per_page=10&format=xml&id=2393462';
        //$url = 'http://datos.madrid.es/portal/site/egob/menuitem.ac61933d6ee3c31cae77ae7784f1a5a0/?vgnextoid=00149033f2201410VgnVCM100000171f5a0aRCRD&format=xml&file=0&filename=206974-0-agenda-eventos-culturales-100&mgmtid=6c0b6d01df986410VgnVCM2000000c205a0aRCRD';
        //$url = 'http://www.zaragoza.es/buscador/select?q=*:*%20AND%20-tipocontenido_s:estatico%20AND%20category:Actividades&rows=50';
        $extension = 'XML';
        try {
            $this->integrationService->integrateAnOpenDataSource(array('url' => $url, 'extension' => $extension));
        }
        catch (Exception $exception)
        {
            //Flash con el error
            dd($exception->getMessage() . $exception->getTraceAsString());
        }
    }

    public function clean()
    {
        $this->integrationService->cleanAllTheEvents();
    }

}
