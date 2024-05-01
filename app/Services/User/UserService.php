<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function changePassword(array $data): void
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        $this->userRepository->update($user->id, [
            'password' => Hash::make($data['password'])
        ]);
    }

}
