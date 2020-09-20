<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestCountHistorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_count_historys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->integer('type_id')->index()->comment('0: Get GeoDB Cities, 1: Get wikidata, 2: Get Yahoo!ローカルサーチAPI, 3: Get 楽天トラベル施設検索API, 4: Get Сurrent weather and forecast');
            $table->timestamp('created_at')->useCurrent()->nullable()->index();
            $table->timestamp('updated_at')->useCurrent()->index();
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
        Schema::dropIfExists('request_count_historys');
    }
}
