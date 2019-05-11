<?php

use App\ListingType;
use Illuminate\Database\Seeder;

class ListingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rent = new ListingType;
        $sale = new ListingType;

        $rent->ListingType = 'rent';
        $sale->ListingType = 'sale';

        $rent->save();
        $sale->save();
    }
}
