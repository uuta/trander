<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_directions', function (Blueprint $table) {
            $table->increments('direction_id');
            $table->string('direction_name')->comment('北、北東、東、南東、南、南西、西、北西');
            $table->float('min_angle')->comment('min angle');
            $table->float('max_angle')->comment('max angle');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_directions');
    }
}
