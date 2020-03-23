<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName, $lastName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fN, $lN)
    {
        $this->firstName = $fN;
        $this->lastName = $lN;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.registration', 
        [
            'firstname' => $this->firstName, 
            'lastname' => $this->lastName
        ]);
    }
}
