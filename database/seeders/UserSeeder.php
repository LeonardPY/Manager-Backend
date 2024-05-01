<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'user_role_id' => 1,
                'password' => 'user123'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'user_role_id' => 2,
                'password' => 'admin123'
            ],
            [
                'name' => 'Department Store',
                'email' => 'store@gmail.com',
                'user_role_id' => 3,
                'password' => 'store123'
            ],
            [
                'name' => 'Department Factory',
                'email' => 'factory@gmail.com',
                'user_role_id' => 4,
                'password' => 'factory123'
            ],
        ];

        foreach ($users as $user) {
            $this->userRepository->firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
