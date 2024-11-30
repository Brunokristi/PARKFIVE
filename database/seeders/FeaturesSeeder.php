<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('features')->insert([
            ['name' => 'Bazén'],
            ['name' => 'Sauna'],
            ['name' => 'Zariadená kuchyňa'],
            ['name' => 'Parkovanie'],
            ['name' => 'Wifi'],
            ['name' => 'Posedenie'],
            ['name' => 'Nefajčiarska izba'],
        ]);
    }
}
