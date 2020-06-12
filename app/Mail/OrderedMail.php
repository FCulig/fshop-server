<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName, $lastName, $productName, $productQuantity;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fN, $lN, $prodN, $prodQ)
    {
        $this->firstName = $fN;
        $this->lastName = $lN;
        $this->productName = $prodN;
        $this->productQuantity = $prodQ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.order',
            [
                'firstname' => $this->firstName,
                'lastname' => $this->lastName,
                'productName' => $this->productName,
                'productQuantity' => $this->productQuantity
            ]);
    }
}
