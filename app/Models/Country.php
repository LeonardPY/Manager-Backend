<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $country_name
 * @property string $iso_code
 * @property string $currency
*/
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
        'iso_code',
        'currency',
    ];
}
