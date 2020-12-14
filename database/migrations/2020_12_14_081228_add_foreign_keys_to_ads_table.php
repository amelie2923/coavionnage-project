<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->foreign('user_id', 'ads_user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('type_ad_id', 'type_ad_id')->references('id')->on('type_ad')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('type_search_id', 'type_search_id')->references('id')->on('type_search')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropForeign('ads_user_id');
            $table->dropForeign('type_ad_id');
            $table->dropForeign('type_search_id');
        });
    }
}
