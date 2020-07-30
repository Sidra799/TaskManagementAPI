<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define('App\Task', function (Faker $faker) {
    return [
        'title' => $faker->title,
        'createdBy' => "16",
        'startDate' => Carbon::now(),
        'priority' => 'high',
        'description' => $faker->paragraph,
        'assignedUserId' => "17",
        'duration' => "2",
        'durationUnit' => "hours",
        'statusId' => "3"

    ];
});
