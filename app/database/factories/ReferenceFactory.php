<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Reference, ReferenceValue};
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Reference::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'key' => Str::slug($name),
        'name' => $name,
    ];
});

$factory->define(ReferenceValue::class, function (Faker $faker) {
    return [
        'reference_id' => factory(Reference::class),
        'value' => $faker->randomDigitNotNull,
    ];
});
