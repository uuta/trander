<?php

namespace Tests\VerifySubscriberTests;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerifySubscriberTestNonNormalOutOfLimitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'unique_id' => config('const.test.sub'),
            ],
        ];
        $request_limits = [
            [
                'user_id' => 1,
                'request_limit' => 0,
            ],
        ];
        DB::table('users')->insert($users);
        DB::table('request_limits')->insert($request_limits);
    }
}
