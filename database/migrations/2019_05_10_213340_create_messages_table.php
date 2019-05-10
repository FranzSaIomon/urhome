<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("Message");
            $table->dateTime("TimeSent");
            $table->dateTime("TimeReceived");

            $table->bigInteger("Receiver")->unsigned(); // user foreign keys
            $table->bigInteger("Sender")->unsigned();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign("Receiver")->references('id')->on('users');
            $table->foreign("Sender")->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
