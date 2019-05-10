<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_amenities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('PropertyID')->unsigned(); // property foreign key
            $table->bigInteger('AmenityID')->unsigned(); // amenity foreign key
            $table->timestamps();
        });

        Schema::table('property_amenities', function (Blueprint $table) {
            $table->foreign("PropertyID")->references("id")->on("properties");
            $table->foreign("AmenityID")->references("id")->on("amenities");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_amenities');
    }
}
