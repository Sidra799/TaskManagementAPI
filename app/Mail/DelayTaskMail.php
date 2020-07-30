<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DelayTaskMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name,$id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$id)
    {
        $this->name=$name;
        $this->id=$id;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.delayTaskMail')->from('sidraashfaq458@gmail.com','Sidra');
    }
}
