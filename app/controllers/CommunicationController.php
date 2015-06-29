<?php

use services\CommunicationService;

class CommunicationController extends \BaseController {

    private $communicationService;

    function __construct(CommunicationService $communicationService)
    {

        $this->communicationService = $communicationService;
    }

    public function create($id)
    {
        $performer = $this->communicationService->getThePerformerInformation($id);

        return View::make('communication.create')->with(array('performer' => $performer));
    }

    public function communicate()
    {
        extract(Input::only('to', 'from', 'subject', 'message'));

        $validator = Validator::make(
            [
                'to' => $to,
                'from' => $from,
                'subject' => $subject,
                'message' => $message
            ],
            [
                'to' => 'required',
                'from' => 'required',
                'subject' => 'required',
                'message' => 'required'
            ]
        );

        if ($validator->fails())
        {
            $errors = $validator->messages();
            return Redirect::back()->withInput()->with(array('errors' => $errors));
        }

        $this->communicationService->sendAnEmail($from, $to, $subject, $message);

        Flash::message(Lang::get('messages.communicate/sent'));

        if (Session::get('event')) return Redirect::route('event_path', array('id' => Session::get('event')));
        else return Redirect::route('events_path');
    }

    public function download()
    {
        $pdf = App::make('dompdf');

        $pdf->loadFile(public_path().'/files/manual.pdf');

        return $pdf->download("manual.pdf");
    }
}
