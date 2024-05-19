<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $countries = [
            ['id' => 1, 'country_name' => 'Armenia', 'iso_code' => 'AM', 'currency' => 'AMD'],
            ['id' => 2, 'country_name' => 'Iran', 'iso_code' => 'IR', 'currency' => 'IRR'],
            ['id' => 3, 'country_name' => 'Georgia', 'iso_code' => 'GE', 'currency' => 'GEL'],
            ['id' => 4, 'country_name' => 'Russia', 'iso_code' => 'RU', 'currency' => 'RUB'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insertOrIgnore($country);
        }
    }
}
