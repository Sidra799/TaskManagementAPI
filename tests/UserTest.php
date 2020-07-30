<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    // public function testUserCanLogin()
    // {

    //     $response = $this->json('POST', '/login', [
    //         "email"  => "admin@gmail.com",
    //         "password" => "Admin123"
    //     ]);

    //     $response
    //         ->assertResponseStatus(200);
            
    // }
    public function testExample()
    {
       
        $this->get('/');

        $this->assertResponseStatus(
            200
        );
        
    }
    // public function testUserCanRegister()
    // {
    //     $user = factory('App\User')->make();
    //     $userData = [
    //         "name" =>  $user->name,
    //         "email" =>  $user->email,
    //         "status" =>  $user->status,
    //         "password" =>  $user->password,
    //         "type" =>  $user->type,
    //         "activationcode" =>  $user->activationcode,
    //         "gender" =>  $user->gender
    //     ];

    //     $response = $this->json('POST', '/register', $userData, ['Accept' => 'application/json']);
    //     $response->assertResponseStatus(200);
    //     $response->seeJson([
    //         "status" => "OK",
    //     ]);
    // }
}
