<?php

namespace App\Enums;

enum ValidationISOCodeEnum: string
{
    case US = '/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i';
    case DE = '/^(?:\d{5})$/i';
    case AM = '/^(?:(?:37)?\d{4})$/i';


    public static function getISO(string $countryCode): ?string
    {
        $countryCode = strtoupper($countryCode);
        return match ($countryCode) {
            ValidationISOCodeEnum::US->name => ValidationISOCodeEnum::US->value,
            ValidationISOCodeEnum::DE->name => ValidationISOCodeEnum::DE->value,
            ValidationISOCodeEnum::AM->name => ValidationISOCodeEnum::AM->value,
            default => null,
        };
    }
}
