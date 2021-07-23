<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeRatingStarToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('google_place_ids', function (Blueprint $table) {
            $table->string('rating_star')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('google_place_ids', function (Blueprint $table) {
            DB::statement('UPDATE `google_place_ids` SET `rating_star` = "" WHERE `rating_star` IS NULL');
            $table->text('rating_star')->nullable(false)->change();
        });
    }
}
