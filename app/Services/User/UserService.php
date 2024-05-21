<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Repositories\UserRepositoryInterface;
use App\Services\PictureService;

readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PictureService          $pictureService
    )
    {
    }

    public function uploadUserLogo(array $data): array
    {
        if (isset($data['logo'])) {
            $lastUser = $this->userRepository->last();
            $nextId = $lastUser ? $lastUser->id + 1 : 1;
            $data['logo'] = $this->pictureService->uploadPicture($data['logo'], 'users/logo/' . $nextId);
        }
        return $data;
    }
}
