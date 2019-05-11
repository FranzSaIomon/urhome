<?php

use App\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array("UserType" => "client"),
            array("UserType" => "broker"),
            array("UserType" => "admin")
        ];

        UserType::insert($data);
    }
}
