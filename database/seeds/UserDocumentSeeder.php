<?php

use Illuminate\Database\Seeder;

class UserDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\UserDocument', 10)->create();
    }
}
