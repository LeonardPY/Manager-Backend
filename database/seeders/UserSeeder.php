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
                'password' => 'user123',
                'email_verified_at' => '2024-01-01 00:00:00'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'user_role_id' => 2,
                'password' => 'admin123',
                'email_verified_at' => '2024-01-02 00:00:00'
            ],
            [
                'name' => 'Department Store',
                'email' => 'store@gmail.com',
                'user_role_id' => 3,
                'password' => 'store123',
                'email_verified_at' => '2024-01-03 00:00:00'
            ],
            [
                'name' => 'Department Factory',
                'email' => 'factory@gmail.com',
                'user_role_id' => 4,
                'password' => 'factory123',
                'email_verified_at' => '2024-01-04 00:00:00'
            ],
        ];

        foreach ($users as $user) {
            $this->userRepository->firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
