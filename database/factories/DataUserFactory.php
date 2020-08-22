<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DataUserModel;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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

$factory->define(DataUserModel::class, function (Faker $faker) {
    return [
        'name'                  => $faker->name,
        'email'                 => $faker->unique()->safeEmail,
        'email_verified_at'     => now(),
        'password'              => Hash::make("password"),
        'last_login_ip'         => '127.0.0.1',
        'last_login'            => now(),
    ];
});
