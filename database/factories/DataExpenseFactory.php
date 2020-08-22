<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DataExpenseModel;
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

$factory->define(DataExpenseModel::class, function (Faker $faker) {
    return [
        'amount'            => $faker->numberBetween($min = 1000, $max = 20000),//PENCE 10000 eg 100.00 from £10-200
        'description'       => $faker->randomElement(['Take out', 'Clothes', 'Groceries', 'Uber', 'Hotel', 'Amazon', 'Fuel']),
    ];
});
