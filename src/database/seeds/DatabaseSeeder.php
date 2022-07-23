<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(['MWaysSeeder']);
        $this->call(['MDirectionSeeder']);
        $this->call(['GooglePlaceIdsSeeder']);
        $this->call(['MRatingsSeeder']);
        $this->call(['MCountriesSeeder']);
    }
}
