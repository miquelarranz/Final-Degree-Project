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
        $url = 'http://api.seatgeek.com/2/events?venue.city=NY&per_page=200';
        //$url = 'http://datos.madrid.es/portal/site/egob/menuitem.ac61933d6ee3c31cae77ae7784f1a5a0/?vgnextoid=00149033f2201410VgnVCM100000171f5a0aRCRD&format=xml&file=0&filename=206974-0-agenda-eventos-culturales-100&mgmtid=6c0b6d01df986410VgnVCM2000000c205a0aRCRD';
        $extension = 'JSON';
        try {
            $this->integrationService->integrateAnOpenDataSource(array('url' => $url, 'extension' => $extension));
        }
        catch (Exception $exception)
        {
            //Flash con el error
            dd($exception->getMessage());
        }
    }

}
