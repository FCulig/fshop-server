<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippedItemMail extends Mailable
{
    use Queueable, SerializesModels;

    public $productName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pn)
    {
        $this->productName = $pn;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.shippedItem',
            [
                'productName' => $this->productName
            ]);
    }
}
