<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MRatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ways = [
            ['id' => 1, 'class_name' => 'c-text_rating_0', 'min' => 0, 'max' => 0.25, 'created_at' => now()],
            ['id' => 2, 'class_name' => 'c-text_rating_0.5', 'min' => 0.25, 'max' => 0.75, 'created_at' => now()],
            ['id' => 3, 'class_name' => 'c-text_rating_1', 'min' => 0.75, 'max' => 1.25, 'created_at' => now()],
            ['id' => 4, 'class_name' => 'c-text_rating_1.5', 'min' => 1.25, 'max' => 1.75, 'created_at' => now()],
            ['id' => 5, 'class_name' => 'c-text_rating_2', 'min' => 1.75, 'max' => 2.25, 'created_at' => now()],
            ['id' => 6, 'class_name' => 'c-text_rating_2.5', 'min' => 2.25, 'max' => 2.75, 'created_at' => now()],
            ['id' => 7, 'class_name' => 'c-text_rating_3', 'min' => 2.75, 'max' => 3.25, 'created_at' => now()],
            ['id' => 8, 'class_name' => 'c-text_rating_3.5', 'min' => 3.25, 'max' => 3.75, 'created_at' => now()],
            ['id' => 9, 'class_name' => 'c-text_rating_4', 'min' => 3.75, 'max' => 4.25, 'created_at' => now()],
            ['id' => 10, 'class_name' => 'c-text_rating_4.5', 'min' => 4.25, 'max' => 4.75, 'created_at' => now()],
            ['id' => 11, 'class_name' => 'c-text_rating_5', 'min' => 4.75, 'max' => 5, 'created_at' => now()],
        ];
        DB::table('m_ratings')->insert($ways);
    }
}
