<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PropertyTypeSeeder::class);
        $this->call(ListingTypeSeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PropertySeeder::class);
        $this->call(PropertyAmenitySeeder::class);
        $this->call(UserDocumentSeeder::class);
        $this->call(PropertyDocumentSeeder::class);

        Model::reguard();
    }
}
