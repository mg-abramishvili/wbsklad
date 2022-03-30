<?php

namespace App\Mail;

use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $verifyKey;

    public function __construct($verifyKey)
    {
        $this->verifyKey = $verifyKey;
    }

    public function build()
    {
        return $this->subject('Подтвердите E-mail')
            ->markdown('emails.UserVerifyEmail')
            ->with([
            'verifyKey' => $this->verifyKey,
        ]);
    }
}
