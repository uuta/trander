<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGooglePlaceIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_place_ids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('place_id')->index()->comment('Place ID');
            $table->string('name')->comment('Place name');
            $table->string('icon')->comment('Icon path');
            $table->float('rating')->nullable()->comment('Average of rating');
            $table->string('photo')->nullable()->comment('Photo ID');
            $table->string('vicinity')->nullable()->comment('Address');
            $table->integer('user_ratings_total')->nullable()->comment('Sum of ratings');
            $table->integer('price_level')->nullable()->comment('Price Level');
            $table->float('lat')->comment('Latitude');
            $table->float('lng')->comment('Longitude');
            $table->string('rating_star')->comment('Class for rating star');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_place_ids');
    }
}
