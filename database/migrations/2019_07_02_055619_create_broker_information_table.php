<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broker_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('UserID')->unsgined();
            
            $table->bigInteger('SubscriptionID')->unsigned()->nullable();
            $table->timestamp('SubscriptionStart')->nullable();

            $table->timestamps();
        });

        Schema::table('broker_information', function (Blueprint $table) {
            // $table->foreign("UserID")->references('id')->on('users');
            $table->foreign("SubscriptionID")->references('id')->on('subscriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broker_information');
    }
}
