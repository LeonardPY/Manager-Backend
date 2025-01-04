<?php

namespace App\Services\Worker;

use App\Enums\PicturesPathEnum;
use App\Enums\UserRoleEnum;
use App\Enums\WorkerRoleEnum;
use App\Models\User;
use App\Models\Worker;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\WorkerRepository;
use App\Services\FilesystemService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Throwable;

readonly class WorkerService
{

    public function __construct(
        private WorkerRepository $workerRepository,
        private UserRepository $userRepository,
        private FilesystemService $filesystemService,
        private DatabaseManager $databaseManager,
    ) {
    }

    /** @throws Throwable */
    public function makeWorker(User $organization, array $data): Worker
    {
        return $this->databaseManager->transaction(function () use ($organization, $data) {
            $userData = $this->makeUserData($organization, $data);
            $user = $this->userRepository->create($userData);
            $workerData = $this->makeWorkerData(organization: $organization, user: $user, data: $data);
            return $this->workerRepository->create($workerData);
        });
    }

    public function makeUserData(User $organization, array $data): array
    {
        return  [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country_id' => $organization->country_id,
            'user_role_id' => UserRoleEnum::WORKER->value,
        ];
    }

    public function uploadPicture(UploadedFile $file, int $userId): string
    {
        $path = PicturesPathEnum::WORKER_PICTURE->value . '/' . $userId;
        return $this->filesystemService->uploadPicture($file, $path);
    }

    public function makeWorkerData(User $organization, User $user, array $data): array
    {
        $picturePath = $this->uploadPicture($data['picture'], $user->id);
        return  [
            'name' => $data['name'],
            'email' => $data['email'],
            'picture' => $picturePath,
            'salary' => $data['salary'] ?? null,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'role_id' => WorkerRoleEnum::SHIPPER->value,
        ];
    }
}
