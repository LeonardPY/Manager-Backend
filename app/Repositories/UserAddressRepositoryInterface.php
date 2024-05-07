<?php

namespace App\Repositories;

interface UserAddressRepositoryInterface extends BaseRepositoryInterface
{
    public function getAddressByUserId(int $userId): object;

    public function getAddressById(int $id): object;
}
