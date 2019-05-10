<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("Name");
            $table->decimal("Price");
            $table->integer("NumberOfUnits");
            $table->string("Features");
            $table->integer("Period");
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign("SubscriptionPlanID")->references('id')->on('subscriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
