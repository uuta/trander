<?php

use App\Http\Models\MRating;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class InsertMasterToMRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ways = [
            ['id' => 1, 'class_name' => '0', 'min' => 0, 'max' => 0.25, 'created_at' => now()],
            ['id' => 2, 'class_name' => '0_5', 'min' => 0.25, 'max' => 0.75, 'created_at' => now()],
            ['id' => 3, 'class_name' => '1', 'min' => 0.75, 'max' => 1.25, 'created_at' => now()],
            ['id' => 4, 'class_name' => '1_5', 'min' => 1.25, 'max' => 1.75, 'created_at' => now()],
            ['id' => 5, 'class_name' => '2', 'min' => 1.75, 'max' => 2.25, 'created_at' => now()],
            ['id' => 6, 'class_name' => '2_5', 'min' => 2.25, 'max' => 2.75, 'created_at' => now()],
            ['id' => 7, 'class_name' => '3', 'min' => 2.75, 'max' => 3.25, 'created_at' => now()],
            ['id' => 8, 'class_name' => '3_5', 'min' => 3.25, 'max' => 3.75, 'created_at' => now()],
            ['id' => 9, 'class_name' => '4', 'min' => 3.75, 'max' => 4.25, 'created_at' => now()],
            ['id' => 10, 'class_name' => '4_5', 'min' => 4.25, 'max' => 4.75, 'created_at' => now()],
            ['id' => 11, 'class_name' => '5', 'min' => 4.75, 'max' => 5, 'created_at' => now()],
        ];
        DB::table('m_ratings')->insert($ways);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        for ($id = 1; $id < 12; $id++) {
            MRating::where('id',  $id)->delete();
        }
    }
}
