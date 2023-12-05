<?php

namespace App\Mail\LoginMails;

use Illuminate\Mail\Mailable;

class RegisterSuccess extends Mailable
{
    public $data;

    public function __construct($customData)
    {
        $this->data = $customData;
    }

    public function build()
    {
        return $this->subject('Registration Completed')
            ->view('emails.login.registersuccess');
    }
}
