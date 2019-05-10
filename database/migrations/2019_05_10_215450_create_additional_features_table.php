<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("Name");
            $table->decimal("Price");
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign("AdditionalFeatureID")->references('id')->on('additional_features');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_features');
    }
}
