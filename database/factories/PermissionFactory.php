<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define("App\Permission", function (Faker $faker) {
    return [
       'name'=>$faker->name
    ];
});
