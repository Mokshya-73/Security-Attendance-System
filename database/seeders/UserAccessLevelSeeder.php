<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAccessLevel;

class UserAccessLevelSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin',
            'Company User',
            'Approver DGM',
            'Security Manager',
            'Patrol Officer',
            'Security Officer'
        ];

        foreach ($roles as $role) {
            UserAccessLevel::firstOrCreate(['role' => $role]);
        }
    }
}
