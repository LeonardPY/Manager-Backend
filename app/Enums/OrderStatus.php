<?php

namespace App\Enums;

enum OrderStatus: int
{
    case IN_CART = 1;
    case PENDING = 2;
    case SHIPPED = 3;
    case DELIVERED = 4;

    public static function refundableStatuses(): array
    {
        return [
            self::IN_CART->value,
            self::PENDING->value,
            self::SHIPPED->value,
            self::DELIVERED->value,
        ];
    }
}
