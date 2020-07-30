<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Roles;
use Faker\Generator as Faker;

$factory->define('App\Roles', function (Faker $faker) {
    return [
        "name" => $faker->name,
        "permissions" => array(1,2)
    ];
});
