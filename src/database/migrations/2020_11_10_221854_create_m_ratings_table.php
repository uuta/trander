<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_name')->comment('Class name to display stars');
            $table->float('min')->comment('Rating of minimum');
            $table->float('max')->comment('Rating of maximum');
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
        Schema::dropIfExists('m_ratings');
    }
}
