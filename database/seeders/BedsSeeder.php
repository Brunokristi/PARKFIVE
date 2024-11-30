<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('beds')->insert([
            ['name' => 'Jednolôžko'],
            ['name' => 'Dvojlôžko'],
            ['name' => 'Queen'],
            ['name' => 'King'],
            ['name' => 'Poschodová posteľ'],
            ['name' => 'Rozkladací gauč'],
        ]);
    }
}
