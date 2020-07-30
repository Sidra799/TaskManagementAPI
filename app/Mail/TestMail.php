<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;
   public $name,$activationcode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$activationcode)
    {
        $this->name=$name;
        $this->activationcode=$activationcode;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.confirmation')->subject('Email Confirmation')->from('sidraashfaq458@gmail.com','Sidra Ashfaq');
    }
}
