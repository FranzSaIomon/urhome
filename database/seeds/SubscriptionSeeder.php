<?php

use App\Feature;
use Illuminate\Database\Seeder;
use App\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basic = new Subscription();
        $basic->Name = "Basic";
        $basic->Price = 1199.00;
        $basic->NumberOfUnits = 5;
        $basic->Period = 1;
        $basic->Features = [Feature::MESSAGING, Feature::UPLOAD];

        $standard = new Subscription();
        $standard->Name = "Standard";
        $standard->Price = 1499.00;
        $standard->NumberOfUnits = 10;
        $standard->Period = 4;
        $standard->Features = [Feature::MESSAGING, Feature::UPLOAD, Feature::REPORT];

        $business = new Subscription();
        $business->Name = "Business";
        $business->Price = 1899.00;
        $business->NumberOfUnits = 15;
        $business->Period = 6;
        $business->Features = [Feature::MESSAGING, Feature::UPLOAD, Feature::REPORT, Feature::B_FEATURED];
        
        $premium = new Subscription();
        $premium->Name = "Premium";
        $premium->Price = 2699.00;
        $premium->NumberOfUnits = 30;
        $premium->Period = 12;
        $premium->Features = [Feature::MESSAGING, Feature::UPLOAD, Feature::REPORT, Feature::P_FEATURED];

        $basic->save();
        $standard->save();
        $business->save();
        $premium->save();
    }
}
