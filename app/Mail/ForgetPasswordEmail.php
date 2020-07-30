<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $token,$id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token,$id)
    {
        $this->token=$token;
        $this->id=$id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgetPassword')->from('sidraashfaq458@gmail.com','Sidra');
    }
}
