<?php

namespace App\Repositories;

interface ResetPasswordRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email): object;
    public function findBy(string $email, string $code): ?object;
}
