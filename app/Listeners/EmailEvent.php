<?php

namespace App\Listeners;

use App\Events\EmailDelayedTasks;
use App\Mail\DelayTaskMail;
use Illuminate\Support\Facades\Mail;

class EmailEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailDelayedTasks  $event
     * @return void
     */
    public function handle(EmailDelayedTasks $event)
    {
        print_r($event->email);
        print_r($event->name);
        echo $event->id;
        if($event->userDesignation == 'lead'){
            Mail::to($event->email)
            ->send(new DelayTaskMail($event->name,$event->id));
        }
        
    }
}
