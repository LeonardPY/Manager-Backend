<?php

namespace App\Repositories\Eloquent;

use App\Enums\UserStatusEnum;
use App\Http\Filters\User\UserFilter;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;

final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    // admin
    public function getUsers(UserFilter $filter)
    {
        return $this->model->with(['country', 'address'])
            ->filter($filter)->paginate($filter->LIMIT, ['*'], 'users_page', $filter->PAGE);
    }

    public function getUsersByRoleId(int $roleId, UserFilter $filter)
    {
        return $this->model->with(['country', 'address'])
            ->where('user_role_id', $roleId)
            ->whereNot('status', UserStatusEnum::DELETED->value)
            ->filter($filter)->paginate($filter->LIMIT, ['*'], 'users_page', $filter->PAGE);
    }
    public function findByEmail(string $email): mixed
    {
        return $this->model->where([
            ['email', $email],
            ['status', '!=', UserStatusEnum::DELETED->value]
        ])->firstOrFail();
    }

    public function users(): object
    {
        return $this->model->whereNot('status', UserStatusEnum::DELETED->value)->paginate(25);
    }

    public function findById(int $id)
    {
        return $this->model->whereNot('status', UserStatusEnum::DELETED->value)->findOrFail($id);
    }
}
