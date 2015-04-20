<?php namespace services;

use IntegrationSystem\core\IntegrationSystem;

class IntegrationService {

    protected $integrationSystem;

    public function __construct(IntegrationSystem $integrationSystem)
    {
        $this->integrationSystem = $integrationSystem;
    }

    public function integrateAnOpenDataSource($data)
    {
        $this->integrationSystem->integrateAnOpenDataSource($data['url'], $data['extension']);
    }


}