<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("ImageAttachment1")->nullable();
            $table->string("ImageAttachment2")->nullable();
            $table->string("FileAttachment1")->nullable();
            $table->string("FileAttachment2")->nullable();
            $table->bigInteger("UserID")->unsigned();
            $table->timestamps();
        });

        Schema::table('user_documents', function (Blueprint $table) {
            $table->foreign("UserID")->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_documents');
    }
}
