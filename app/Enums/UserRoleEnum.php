<?php

namespace App\Enums;

enum UserRoleEnum : int
{
    case  USER = 1;
    case  ADMIN = 2;
    case DEPARTMENT_STORE = 3;
    case DEPARTMENT_FACTORY = 4;

    public function getRole(): string
    {
        return match ($this->value) {
            self::ADMIN->value => 'admin',
            self::DEPARTMENT_STORE->value => 'department_store',
            self::DEPARTMENT_FACTORY->value => 'department_factory',
            default => 'user',
        };
    }
}
