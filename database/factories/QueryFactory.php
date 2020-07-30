<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Query;
use Faker\Generator as Faker;

$factory->define('App\Query', function (Faker $faker) {
    return [
        'query' => $faker->paragraph,
        'fromUid' => factory(App\User::class),
        'toUid' => factory(App\User::class),
        'taskId' => factory(App\Task::class),
        'fromName' => function (array $query) {
            return App\User::find($query['fromUid'])->name;
        },
        'toName' => function (array $query) {
            return App\User::find($query['toUid'])->name;
        },
        'taskTitle' => function (array $query) {
            return App\Task::find($query['taskId'])->title;
        },
        'toEmail' => function (array $query) {
            return App\User::find($query['toUid'])->email;
        },
        'fromEmail' => function (array $query) {
            return App\User::find($query['fromUid'])->email;
        }
    ];
});
