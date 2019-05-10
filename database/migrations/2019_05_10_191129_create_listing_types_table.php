<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ListingType', 20);
            $table->timestamps();
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->foreign("ListingTypeID")->references('id')->on('listing_types'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_types');
    }
}
