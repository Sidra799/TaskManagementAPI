<?php

namespace App\Events;

class EmailDelayedTasks extends Event
{
    public $email,$name,$id,$userDesignation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email,$name,$id,$userDesignation)
    {
        $this->email=$email;
        $this->name=$name;
        $this->id=$id;
        $this->userDesignation=$userDesignation;

    }
}