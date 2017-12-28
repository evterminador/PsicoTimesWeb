<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->string('email', 150)->unique();
            $table->string('first_name', 200)->nullable();
            $table->string('last_name',200)->nullable();
            $table->dateTime('birth_date')->nullable();
            $table->string('dni')->nullable();
            $table->string('state')->nullable();
            $table->boolean('working')->nullable();
            $table->string('profession')->nullable();
            $table->string('sex')->nullable();
            $table->integer('use_time')->nullable();
            $table->text('description')->nullable();
            $table->string('token', 100)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
