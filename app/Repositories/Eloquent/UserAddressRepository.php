<?php

namespace App\Repositories\Eloquent;

use App\Models\UserAddress;
use App\Repositories\UserAddressRepositoryInterface;


final class UserAddressRepository extends BaseRepository implements UserAddressRepositoryInterface
{
    public function __construct(UserAddress $model)
    {
        parent::__construct($model);
    }

    public function getAddressByUserId(int $userId): object
    {
        return $this->model->with(['user', 'country'])->where('user_id', $userId)->get();
    }
}
