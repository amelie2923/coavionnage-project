<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('subject');
            $table->integer('message');
            $table->string('status');
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('sender_id');
            $table->integer('recipient_id')->index('recipient_id');
            $table->index(['sender_id', 'recipient_id'], 'sender_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messaging');
    }
}
