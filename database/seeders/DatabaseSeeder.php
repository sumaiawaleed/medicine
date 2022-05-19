<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(UserTableSeeder::class);
//        $this->call(SiteSeeder::class);
//        $this->call(PlaceSeeder::class);
    }
}
