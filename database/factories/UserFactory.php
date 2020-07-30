<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define('App\User', function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => $faker->password,
        'status' => 0,
        'type' => 'user',
        "activationcode" => 'e7b587a2cd3f9ed7d34d0f56aca7e5df',
        "gender" => 'male',
        'roles_id'=>2
    ];
});
