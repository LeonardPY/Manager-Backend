<?php

namespace App\Enums;

enum UserRoleEnum : int
{
    case  USER = 1;
    case  ADMIN = 2;
    case DEPARTMENT_STORE = 3;
    case ORGANIZATION = 4;

    case WORKER = 5;
    public function getRole(): string
    {
        return match ($this->value) {
            self::ADMIN->value => 'admin',
            self::DEPARTMENT_STORE->value => 'department_store',
            self::ORGANIZATION->value => 'organization',
            self::WORKER->value => 'worker',
            default => 'user',
        };
    }
}
