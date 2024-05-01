<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRoles = [
            [
                'id' => 1,
                'role' => 'user'
            ],
            [
                'id' => 2,
                'role' => 'admin'
            ],
            [
                'id' => 3,
                'role' => 'department_store'
            ],
            [
                'id' => 4,
                'role' => 'department_factory'
            ]
        ];
        UserRole::query()->insertOrIgnore($userRoles);
    }
}
