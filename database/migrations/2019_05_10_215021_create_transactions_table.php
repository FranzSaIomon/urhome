<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('UserID')->unsigned();
            $table->bigInteger('AdditionalFeatureID')->unsigned();
            $table->bigInteger('SubscriptionPlanID')->unsigned();
            $table->decimal("TotalPrice");
        });

        Schema::table('transactions', function (Blueprint $table) {
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
        Schema::dropIfExists('transactions');
    }
}
