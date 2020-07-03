<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MWaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ways = [
            ['way_id' => 1, 'recommend_frequency' => 0, 'min_distance' => 30, 'max_distance' => 10000, 'created_at' => now()],
            ['way_id' => 1, 'recommend_frequency' => 1, 'min_distance' => 10, 'max_distance' => 30, 'created_at' => now()],
            ['way_id' => 1, 'recommend_frequency' => 2, 'min_distance' => 0, 'max_distance' => 10, 'created_at' => now()],
            ['way_id' => 2, 'recommend_frequency' => 0, 'min_distance' => 100, 'max_distance' => 10000, 'created_at' => now()],
            ['way_id' => 2, 'recommend_frequency' => 1, 'min_distance' => 100, 'max_distance' => 10000, 'created_at' => now()],
            ['way_id' => 2, 'recommend_frequency' => 1, 'min_distance' => 0, 'max_distance' => 15, 'created_at' => now()],
            ['way_id' => 2, 'recommend_frequency' => 1, 'min_distance' => 50, 'max_distance' => 100, 'created_at' => now()],
            ['way_id' => 2, 'recommend_frequency' => 2, 'min_distance' => 15, 'max_distance' => 50, 'created_at' => now()],
            ['way_id' => 3, 'recommend_frequency' => 0, 'min_distance' => 0, 'max_distance' => 3, 'created_at' => now()],
            ['way_id' => 3, 'recommend_frequency' => 0, 'min_distance' => 500, 'max_distance' => 10000, 'created_at' => now()],
            ['way_id' => 3, 'recommend_frequency' => 1, 'min_distance' => 150, 'max_distance' => 500, 'created_at' => now()],
            ['way_id' => 3, 'recommend_frequency' => 1, 'min_distance' => 3, 'max_distance' => 20, 'created_at' => now()],
            ['way_id' => 3, 'recommend_frequency' => 2, 'min_distance' => 20, 'max_distance' => 150, 'created_at' => now()],
        ];
        DB::table('m_ways')->insert($ways);
    }
}
