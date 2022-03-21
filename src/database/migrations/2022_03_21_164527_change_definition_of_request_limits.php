<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefinitionOfRequestLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_limits', function (Blueprint $table) {
            $table->bigInteger('request_limit')->unsigned()->default(10)->comment('Number of request limit')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_limits', function (Blueprint $table) {
            $table->bigInteger('request_limit')->unsigned()->default(5)->change();
        });
    }
}
