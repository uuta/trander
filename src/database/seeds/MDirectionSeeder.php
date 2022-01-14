<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MDirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeder = [
            ['direction_id' => 1, 'direction_name' => 'North', 'min_angle' => 337.5, 'max_angle' => 360, 'created_at' => now()],
            ['direction_id' => 2, 'direction_name' => 'North', 'min_angle' => 0, 'max_angle' => 22.5, 'created_at' => now()],
            ['direction_id' => 3, 'direction_name' => 'North East', 'min_angle' => 22.5, 'max_angle' => 67.5, 'created_at' => now()],
            ['direction_id' => 4, 'direction_name' => 'East', 'min_angle' => 67.5, 'max_angle' => 112.5, 'created_at' => now()],
            ['direction_id' => 5, 'direction_name' => 'South East', 'min_angle' => 112.5, 'max_angle' => 157.5, 'created_at' => now()],
            ['direction_id' => 6, 'direction_name' => 'South', 'min_angle' => 157.5, 'max_angle' => 202.5, 'created_at' => now()],
            ['direction_id' => 7, 'direction_name' => 'South West', 'min_angle' => 202.5, 'max_angle' => 247.5, 'created_at' => now()],
            ['direction_id' => 8, 'direction_name' => 'West', 'min_angle' => 247.5, 'max_angle' => 292.5, 'created_at' => now()],
            ['direction_id' => 9, 'direction_name' => 'North West', 'min_angle' => 292.5, 'max_angle' => 337.5, 'created_at' => now()],
        ];
        DB::table('m_directions')->insert($seeder);
    }
}
