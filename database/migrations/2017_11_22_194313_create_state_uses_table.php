<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_uses', function (Blueprint $table) {
            $table->integer('id_users')->unsigned();
            $table->integer('id_app')->unsigned();
            $table->bigInteger('timeUse');
            $table->integer('quantity');
            $table->timestamp('lastUseTime');
            $table->primary(['id_users', 'id_app']);
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_app')->references('id')->on('applications')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('state_uses');
    }
}
