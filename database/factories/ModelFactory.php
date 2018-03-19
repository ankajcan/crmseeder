<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {

    return [
        'first_name' => 'Admin',
        'last_name' => 'Admin',
        'email' => $faker->email(),
        'password' => 'password',
        'remember_token' => str_random(10),
        'confirmed' => 1
    ];
});

$factory->define(\Spatie\Permission\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Admin'
    ];
});

