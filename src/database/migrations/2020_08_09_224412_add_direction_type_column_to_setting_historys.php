<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDirectionTypeColumnToSettingHistorys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_historys', function (Blueprint $table) {
            $table->smallInteger('direction_type')->after('max_distance')->comment('0. None, 1. North, 2. East, 3. South, 4. West');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_historys', function (Blueprint $table) {
            $table->dropColumn('direction_type');
        });
    }
}
