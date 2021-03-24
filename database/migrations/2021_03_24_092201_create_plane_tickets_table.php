<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaneTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plane_tickets', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('plane_tickets_user_id');
            $table->dateTime('date');
            $table->string('departure_city');
            $table->string('arrival_city');
            $table->text('description')->nullable();
            $table->string('company');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plane_tickets');
    }
}
