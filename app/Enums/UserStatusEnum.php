<?php

namespace App\Enums;

enum UserStatusEnum: int
{
    case PUBLIC  = 1;
    case DELETED = 2;

    public function getCategoryStatus(): string
    {
        return match ($this) {
            self::PUBLIC => 'public',
            self::DELETED => 'deleted',
        };
    }

}
