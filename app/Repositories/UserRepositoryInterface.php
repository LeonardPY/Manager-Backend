<?php

namespace App\Repositories;

use App\Http\Filters\User\UserFilter;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    //admin
    public function getUsers(UserFilter $filter);

    public function findById(int $id);
    public function findByEmail(string $email);
    public function users(): object;
}
