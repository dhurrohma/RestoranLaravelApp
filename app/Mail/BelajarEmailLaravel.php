<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BelajarEmailLaravel extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($i)
    {
        $this->i = $i;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Email ke-' . ($this->i);

        return $this->view('Email.Email')
                    ->subject($subject)
                    ->from('dhurrohma28@gmail.com', 'Dhur Rohma')
                    ->with(['i' => $this->i]);
    }
}
