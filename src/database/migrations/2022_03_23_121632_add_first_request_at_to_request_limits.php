<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstRequestAtToRequestLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_limits', function (Blueprint $table) {
            $table->dateTime('first_request_at')->default(
                DB::raw('CURRENT_TIMESTAMP')
            )->after('request_limit')->comment('The first request at');
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
            $table->dropColumn('first_request_at');
        });
    }
}
