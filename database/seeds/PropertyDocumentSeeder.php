<?php

use Illuminate\Database\Seeder;

class PropertyDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\PropertyDocument', 100)->create();
    }
}
