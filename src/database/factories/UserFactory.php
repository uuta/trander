<?php

use Illuminate\Support\Str;
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

/**
 * ユーザー登録
 */
$factory->define(App\Http\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'unique_id' => config('const.test.sub'),
        'email' => 'trander.cs@gmail.com',
    ];
});
