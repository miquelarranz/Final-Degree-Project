<?php namespace services;

use Illuminate\Support\Facades\Mail;
use repositories\OrganizationRepository;

class CommunicationService {

    private $organizationRepository;

    function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    public function getThePerformerInformation($id)
    {
        return $this->organizationRepository->read($id);
    }

    public function sendAnEmail($from, $to, $subject, $body)
    {
        Mail::send('communication/partials.email', array('from' => $from, 'subject' => $subject, 'body' => $body), function($message)
        {
            $message->to('miquelarranz@gmail.com', 'Miquel Arranz')->subject('Hello!');
        });
    }
}