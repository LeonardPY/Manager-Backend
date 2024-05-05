<?php

namespace App\Repositories;

interface ResetPasswordRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email);
}
