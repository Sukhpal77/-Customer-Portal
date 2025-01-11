<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MFAEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mfaToken;

    public function __construct($mfaToken)
    {
        $this->mfaToken = $mfaToken;
    }

    public function build()
    {
        return $this->view('emails.mfa_email') // Path to the email view
                    ->subject('Your MFA Token')
                    ->with('mfaToken', $this->mfaToken);
    }
}
