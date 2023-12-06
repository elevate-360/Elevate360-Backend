<?php

namespace App\Mail\LoginMails;

use Illuminate\Mail\Mailable;

class LoginSuccess extends Mailable
{
    public $data;

    public function __construct($customData)
    {
        $this->data = $customData;
    }

    public function build()
    {
        return $this->subject('Login Attempted')
            ->view('emails.login.loginsuccess');
    }
}
