<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("Name", 100);
            $table->string("Description", 500);
            $table->string("Developer", 100);
            $table->integer("LotNo", false, true);
            $table->string("Street", 100);
            $table->string("City", 100);
            $table->string("Country", 100);
            $table->integer("YearBuilt", false, true);
            $table->float("FloorArea");
            $table->float("LotArea");
            $table->double("Price");
            $table->integer("NumberOfBedrooms");
            $table->integer("NumberOfBathrooms");
            $table->integer("CapacityOfGarage");
            $table->tinyInteger("Verified", false, true);

            $table->bigInteger("UserID")->unsigned(); // user foreign key
            $table->bigInteger("ListingTypeID")->unsigned(); // listing type foreign key
            $table->bigInteger("StatusID")->unsigned(); // statuses foreign key
            $table->bigInteger("PropertyTypeID")->unsigned(); // property type foreign key
            $table->timestamps(); // contains listdate
        });

        Schema::table('properties', function (Blueprint $table) {
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
        Schema::dropIfExists('properties');
    }
}
