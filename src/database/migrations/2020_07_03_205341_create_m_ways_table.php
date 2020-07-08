<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_ways', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('way_id')->comment('1: walking, 2: bycicle, 3: car');
            $table->integer('recommend_frequency')->comment('0: none, 1: middle, 2: high');
            $table->integer('min_distance')->comment('min distance');
            $table->integer('max_distance')->comment('max distance');
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
        Schema::dropIfExists('m_ways');
    }
}
