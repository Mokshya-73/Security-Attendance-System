<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shift_types')->insert([
            ['name' => '8H',  'duration' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['name' => '12H', 'duration' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '24H', 'duration' => 24, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
