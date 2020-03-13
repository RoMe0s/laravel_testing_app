<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{User, TempInsurance};
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(TempInsurance::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'case' => $faker->name,
        'mileage' => $faker->numberBetween(0, 100000),
        'bought_at' => $faker->dateTime,
    ];
});
