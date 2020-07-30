<?php
 namespace App;

 use Twilio\Rest\Client;
 
 class Twilio 
 {
     protected $account_sid;
 
     protected $auth_token;
 
     protected $number;
 
     protected $client;
 
     /**
      * Create a new instance
      * 
      * @return void
      */
 
     public function __construct()
     {
         $this->account_sid = env('TWILIO_ACCOUNT_SID');
 
         $this->auth_token = env('TWILIO_AUTH_TOKEN');
 
         $this->number = env('TWILIO_SMS_FROM');
 
         $this->client = $this->setUp();
     }
 
     public function setUp()
     {
         $client = new Client($this->account_sid, $this->auth_token);
 
         return $client;
     }
 
     public static function notify($number, string $message)
     {
        $message = self::$client->messages->create($number, [
             'from' => self::$number,
             'body' => $message
         ]);
 
         return $message;
     }
 }
