<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanoramaRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panorama_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('PropertyID')->unsigned();
            $table->timestamps();
        });

        Schema::table('property_documents', function (Blueprint $table) {
            $table->foreign("PropertyID")->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panorama_requests');
    }
}
