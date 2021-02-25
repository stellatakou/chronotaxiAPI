<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $confirmation_code;

    public function __construct($user, $confirmation_code)
    {
        $this->user = $user;
        $this->confirmation_code = $confirmation_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Vérification d'email")->view('emails.verify')->with([
            "user"  => $this->user,
            "confirmation_code" => $this->confirmation_code
        ]);
    }
}
