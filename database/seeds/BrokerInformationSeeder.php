<?php

use Illuminate\Database\Seeder;

class BrokerInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\BrokerInformation', 10)->create();
    }
}
