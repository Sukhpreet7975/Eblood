<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class EmergencyRequestMail extends Mailable
{
    public $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function build()
    {
        return $this->subject('New Emergency Blood Request')
            ->view('emails.emergency-request');
    }
}