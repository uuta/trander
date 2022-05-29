<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false)->default('')->comment('country name');
            $table->string('country_code')->nullable(false)->default('')->comment('country code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_countries');
    }
}
