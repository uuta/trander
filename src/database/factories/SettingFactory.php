<?php

use Faker\Generator as Faker;
use App\Http\Models\Setting;
use App\Http\Models\User;

/**
 * setting登録
 */
$factory->define(Setting::class, function (Faker $faker) {
    return [
        'user_id' => null,
        'min_distance' => null,
        'max_distance' => null,
        'direction_type' => null,
    ];
});

/**
 * setting登録（ユーザー登録・範囲内の距離）
 */
$factory->state(Setting::class, 'register user and safe distance', function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'min_distance' => 15,
        'max_distance' => 78,
        'direction_type' => Setting::DIRECTION_TYPE['east'],
    ];
});
