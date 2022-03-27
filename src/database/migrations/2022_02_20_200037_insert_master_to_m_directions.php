<?php

use App\Http\Models\MDirection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class InsertMasterToMDirections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        for ($id = 1; $id < 10; $id++) {
            MDirection::where('direction_id',  $id)->delete();
        }
    }
}
