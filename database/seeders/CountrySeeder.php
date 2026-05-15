<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['iso_code' => 'RW', 'name' => 'Rwanda', 'phone_code' => '250'],
            ['iso_code' => 'KE', 'name' => 'Kenya', 'phone_code' => '254'],
            ['iso_code' => 'UG', 'name' => 'Uganda', 'phone_code' => '256'],
            ['iso_code' => 'TZ', 'name' => 'Tanzania', 'phone_code' => '255'],
            ['iso_code' => 'BI', 'name' => 'Burundi', 'phone_code' => '257'],
            ['iso_code' => 'CD', 'name' => 'DR Congo', 'phone_code' => '243'],
            ['iso_code' => 'US', 'name' => 'United States', 'phone_code' => '1'],
            ['iso_code' => 'GB', 'name' => 'United Kingdom', 'phone_code' => '44'],
            ['iso_code' => 'CA', 'name' => 'Canada', 'phone_code' => '1'],
            ['iso_code' => 'FR', 'name' => 'France', 'phone_code' => '33'],
            ['iso_code' => 'DE', 'name' => 'Germany', 'phone_code' => '49'],
            ['iso_code' => 'IN', 'name' => 'India', 'phone_code' => '91'],
            ['iso_code' => 'CN', 'name' => 'China', 'phone_code' => '86'],
            ['iso_code' => 'AE', 'name' => 'United Arab Emirates', 'phone_code' => '971'],
            ['iso_code' => 'ZA', 'name' => 'South Africa', 'phone_code' => '27'],
            ['iso_code' => 'NG', 'name' => 'Nigeria', 'phone_code' => '234'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso_code' => $country['iso_code']],
                [
                    'name' => $country['name'],
                    'phone_code' => $country['phone_code'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Successfully seeded ' . count($countries) . ' countries.');
    }
}