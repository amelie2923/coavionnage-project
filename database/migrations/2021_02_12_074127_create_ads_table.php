<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('type_search_id')->index('type_search_id');
            $table->date('date');
            $table->string('departure_city');
            $table->string('arrival_city');
            $table->integer('number_animals');
            $table->text('description');
            $table->string('company');
            $table->string('image')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            $table->index(['user_id', 'type_search_id'], 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
