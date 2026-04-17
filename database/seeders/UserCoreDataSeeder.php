<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\UserCoreData;

class UserCoreDataSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['employee_id' => 'ADMIN001', 'role_id' => 1, 'email' => 'admin@security.com'],
            ['employee_id' => 'COMP001',  'role_id' => 2, 'email' => 'company@security.com'],
            ['employee_id' => 'DGM001',   'role_id' => 3, 'email' => 'approverdgm@security.com'],
            ['employee_id' => 'MGR001',   'role_id' => 4, 'email' => 'manager@security.com'],
            ['employee_id' => 'PO001',    'role_id' => 5, 'email' => 'patrol@security.com'],
            ['employee_id' => 'SO001',    'role_id' => 6, 'email' => 'officer@security.com'],
        ];

        foreach ($users as $user) {
            UserCoreData::updateOrCreate(
                ['employee_id' => $user['employee_id']],
                [
                    'email' => $user['email'],
                    'role_id' => $user['role_id'],
                    'password' => Hash::make('12345678'),
                    'status' => 'active',
                ]
            );
        }
    }
}
