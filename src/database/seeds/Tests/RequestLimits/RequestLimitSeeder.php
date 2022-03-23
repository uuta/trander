<?php

namespace Tests\RequestLimits;

use Carbon\Carbon;
use App\Consts\TimeConst;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $day6 = (new Carbon())->subDays(6)->format(TimeConst::DATETIME);
        $day12 = (new Carbon())->subDays(12)->format(TimeConst::DATETIME);

        $users = [
            [
                'id' => 1,
                'unique_id' => config('const.test.sub'),
            ],
            [
                'id' => 2,
                'unique_id' => 'user_2',
            ],
            [
                'id' => 3,
                'unique_id' => 'user_3',
            ],
            [
                'id' => 4,
                'unique_id' => 'user_4',
            ],
        ];
        $request_limits = [
            [
                'user_id' => 1,
                'request_limit' => 10,
                'first_request_at' => $day6,
            ],
            [
                'user_id' => 2,
                'request_limit' => 10,
                'first_request_at' => $day12,
            ],
            [
                'user_id' => 3,
                'request_limit' => 2,
                'first_request_at' => $day6,
            ],
            [
                'user_id' => 4,
                'request_limit' => 5,
                'first_request_at' => $day12,
            ],
        ];
        DB::table('users')->insert($users);
        DB::table('request_limits')->insert($request_limits);
    }
}
