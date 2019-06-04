<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            /* Custom User Model Attributes */
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('ContactNo');
            $table->date('Birthdate');
            $table->integer("LotNo", false, true);
            $table->string("Street", 100);
            $table->string("City", 100);
            $table->string("Country", 100);
            $table->string('Status')->default('No significant status');
            $table->string('ProfileImage')->default('https://via.placeholder.com/30');
            $table->bigInteger('UserType')->unsigned()->default(1); // user type foreign key

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
