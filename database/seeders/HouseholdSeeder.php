<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Household;

class HouseholdSeeder extends Seeder
{
    public function run()
    {
        Household::factory(2)->create();
    }
}
