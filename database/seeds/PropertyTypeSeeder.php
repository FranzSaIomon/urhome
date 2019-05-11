<?php

use App\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $th = new PropertyType;
        $h = new PropertyType;
        $c = new PropertyType;
        $con = new PropertyType;
        $sa = new PropertyType;

        $th->PropertyType = "Town House";
        $h->PropertyType = "Home";
        $c->PropertyType = "Condominium";
        $con->PropertyType = "Condotel";
        $sa->PropertyType = "Service Apartment";

        $th->save(); 
        $h->save();
        $c->save();
        $con->save();
        $sa->save(); 
    }
}
