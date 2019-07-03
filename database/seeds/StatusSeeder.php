<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $av = new Status;
        $ar = new Status;

        $av->Status = "Available";
        $ar->Status = "Archived";
        
        $av->save();
        $ar->save();
    }
}
