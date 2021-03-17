<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('name');
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('api_token', 100)->nullable();
            $table->string('picture')->nullable();
            $table->integer('role_id')->nullable()->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
