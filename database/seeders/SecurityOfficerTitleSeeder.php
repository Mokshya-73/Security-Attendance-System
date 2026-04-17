<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SecurityOfficerTitle;

class SecurityOfficerTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $titles = ['OIC', 'ISO', 'LSO', 'JSO'];

        foreach ($titles as $title) {
            SecurityOfficerTitle::firstOrCreate(['title' => $title]);
        }
    }
}
