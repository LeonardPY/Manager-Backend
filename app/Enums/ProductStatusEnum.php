<?php

namespace App\Enums;

enum ProductStatusEnum: int
{
    case PUBLIC  = 1;
    case DELETED = 2;
    case HIDE = 3;

    public function getProductStatus(): string
    {
        return match ($this) {
            self::PUBLIC => 'public',
            self::DELETED => 'deleted',
            self::HIDE => 'hide',
        };
    }

}
