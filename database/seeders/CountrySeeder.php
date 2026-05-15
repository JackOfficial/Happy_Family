<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            // East African Community (Priority)
            ['iso_code' => 'RW', 'name' => 'Rwanda', 'phone_code' => '250'],
            ['iso_code' => 'KE', 'name' => 'Kenya', 'phone_code' => '254'],
            ['iso_code' => 'UG', 'name' => 'Uganda', 'phone_code' => '256'],
            ['iso_code' => 'TZ', 'name' => 'Tanzania', 'phone_code' => '255'],
            ['iso_code' => 'BI', 'name' => 'Burundi', 'phone_code' => '257'],
            ['iso_code' => 'CD', 'name' => 'DR Congo', 'phone_code' => '243'],
            ['iso_code' => 'SS', 'name' => 'South Sudan', 'phone_code' => '211'],
            ['iso_code' => 'SO', 'name' => 'Somalia', 'phone_code' => '252'],
            ['iso_code' => 'ET', 'name' => 'Ethiopia', 'phone_code' => '251'],

            // Africa (Rest of Continent)
            ['iso_code' => 'DZ', 'name' => 'Algeria', 'phone_code' => '213'],
            ['iso_code' => 'AO', 'name' => 'Angola', 'phone_code' => '244'],
            ['iso_code' => 'BJ', 'name' => 'Benin', 'phone_code' => '229'],
            ['iso_code' => 'BW', 'name' => 'Botswana', 'phone_code' => '267'],
            ['iso_code' => 'BF', 'name' => 'Burkina Faso', 'phone_code' => '226'],
            ['iso_code' => 'CM', 'name' => 'Cameroon', 'phone_code' => '237'],
            ['iso_code' => 'CV', 'name' => 'Cape Verde', 'phone_code' => '238'],
            ['iso_code' => 'CF', 'name' => 'Central African Republic', 'phone_code' => '236'],
            ['iso_code' => 'TD', 'name' => 'Chad', 'phone_code' => '235'],
            ['iso_code' => 'KM', 'name' => 'Comoros', 'phone_code' => '269'],
            ['iso_code' => 'CG', 'name' => 'Congo', 'phone_code' => '242'],
            ['iso_code' => 'CI', 'name' => 'Côte d\'Ivoire', 'phone_code' => '225'],
            ['iso_code' => 'DJ', 'name' => 'Djibouti', 'phone_code' => '253'],
            ['iso_code' => 'EG', 'name' => 'Egypt', 'phone_code' => '20'],
            ['iso_code' => 'GQ', 'name' => 'Equatorial Guinea', 'phone_code' => '240'],
            ['iso_code' => 'ER', 'name' => 'Eritrea', 'phone_code' => '291'],
            ['iso_code' => 'SZ', 'name' => 'Eswatini', 'phone_code' => '268'],
            ['iso_code' => 'GA', 'name' => 'Gabon', 'phone_code' => '241'],
            ['iso_code' => 'GM', 'name' => 'Gambia', 'phone_code' => '220'],
            ['iso_code' => 'GH', 'name' => 'Ghana', 'phone_code' => '233'],
            ['iso_code' => 'GN', 'name' => 'Guinea', 'phone_code' => '224'],
            ['iso_code' => 'GW', 'name' => 'Guinea-Bissau', 'phone_code' => '245'],
            ['iso_code' => 'LS', 'name' => 'Lesotho', 'phone_code' => '266'],
            ['iso_code' => 'LR', 'name' => 'Liberia', 'phone_code' => '231'],
            ['iso_code' => 'LY', 'name' => 'Libya', 'phone_code' => '218'],
            ['iso_code' => 'MG', 'name' => 'Madagascar', 'phone_code' => '261'],
            ['iso_code' => 'MW', 'name' => 'Malawi', 'phone_code' => '265'],
            ['iso_code' => 'ML', 'name' => 'Mali', 'phone_code' => '223'],
            ['iso_code' => 'MR', 'name' => 'Mauritania', 'phone_code' => '222'],
            ['iso_code' => 'MU', 'name' => 'Mauritius', 'phone_code' => '230'],
            ['iso_code' => 'MA', 'name' => 'Morocco', 'phone_code' => '212'],
            ['iso_code' => 'MZ', 'name' => 'Mozambique', 'phone_code' => '258'],
            ['iso_code' => 'NA', 'name' => 'Namibia', 'phone_code' => '264'],
            ['iso_code' => 'NE', 'name' => 'Niger', 'phone_code' => '227'],
            ['iso_code' => 'NG', 'name' => 'Nigeria', 'phone_code' => '234'],
            ['iso_code' => 'RE', 'name' => 'Réunion', 'phone_code' => '262'],
            ['iso_code' => 'ST', 'name' => 'São Tomé and Príncipe', 'phone_code' => '239'],
            ['iso_code' => 'SN', 'name' => 'Senegal', 'phone_code' => '221'],
            ['iso_code' => 'SC', 'name' => 'Seychelles', 'phone_code' => '248'],
            ['iso_code' => 'SL', 'name' => 'Sierra Leone', 'phone_code' => '232'],
            ['iso_code' => 'ZA', 'name' => 'South Africa', 'phone_code' => '27'],
            ['iso_code' => 'SD', 'name' => 'Sudan', 'phone_code' => '249'],
            ['iso_code' => 'TG', 'name' => 'Togo', 'phone_code' => '228'],
            ['iso_code' => 'TN', 'name' => 'Tunisia', 'phone_code' => '216'],
            ['iso_code' => 'ZM', 'name' => 'Zambia', 'phone_code' => '260'],
            ['iso_code' => 'ZW', 'name' => 'Zimbabwe', 'phone_code' => '263'],

            // Europe
            ['iso_code' => 'GB', 'name' => 'United Kingdom', 'phone_code' => '44'],
            ['iso_code' => 'FR', 'name' => 'France', 'phone_code' => '33'],
            ['iso_code' => 'DE', 'name' => 'Germany', 'phone_code' => '49'],
            ['iso_code' => 'IT', 'name' => 'Italy', 'phone_code' => '39'],
            ['iso_code' => 'ES', 'name' => 'Spain', 'phone_code' => '34'],
            ['iso_code' => 'NL', 'name' => 'Netherlands', 'phone_code' => '31'],
            ['iso_code' => 'BE', 'name' => 'Belgium', 'phone_code' => '32'],
            ['iso_code' => 'CH', 'name' => 'Switzerland', 'phone_code' => '41'],
            ['iso_code' => 'SE', 'name' => 'Sweden', 'phone_code' => '46'],
            ['iso_code' => 'NO', 'name' => 'Norway', 'phone_code' => '47'],
            ['iso_code' => 'DK', 'name' => 'Denmark', 'phone_code' => '45'],
            ['iso_code' => 'FI', 'name' => 'Finland', 'phone_code' => '358'],
            ['iso_code' => 'IE', 'name' => 'Ireland', 'phone_code' => '353'],
            ['iso_code' => 'PT', 'name' => 'Portugal', 'phone_code' => '351'],
            ['iso_code' => 'TR', 'name' => 'Turkey', 'phone_code' => '90'],
            ['iso_code' => 'UA', 'name' => 'Ukraine', 'phone_code' => '380'],
            ['iso_code' => 'PL', 'name' => 'Poland', 'phone_code' => '48'],

            // North America
            ['iso_code' => 'US', 'name' => 'United States', 'phone_code' => '1'],
            ['iso_code' => 'CA', 'name' => 'Canada', 'phone_code' => '1'],
            ['iso_code' => 'MX', 'name' => 'Mexico', 'phone_code' => '52'],

            // Middle East & Asia
            ['iso_code' => 'AE', 'name' => 'United Arab Emirates', 'phone_code' => '971'],
            ['iso_code' => 'SA', 'name' => 'Saudi Arabia', 'phone_code' => '966'],
            ['iso_code' => 'QA', 'name' => 'Qatar', 'phone_code' => '974'],
            ['iso_code' => 'IN', 'name' => 'India', 'phone_code' => '91'],
            ['iso_code' => 'CN', 'name' => 'China', 'phone_code' => '86'],
            ['iso_code' => 'JP', 'name' => 'Japan', 'phone_code' => '81'],
            ['iso_code' => 'KR', 'name' => 'South Korea', 'phone_code' => '82'],
            ['iso_code' => 'SG', 'name' => 'Singapore', 'phone_code' => '65'],
            ['iso_code' => 'MY', 'name' => 'Malaysia', 'phone_code' => '60'],
            ['iso_code' => 'ID', 'name' => 'Indonesia', 'phone_code' => '62'],
            ['iso_code' => 'PK', 'name' => 'Pakistan', 'phone_code' => '92'],
            ['iso_code' => 'BD', 'name' => 'Bangladesh', 'phone_code' => '880'],
            ['iso_code' => 'VN', 'name' => 'Vietnam', 'phone_code' => '84'],
            ['iso_code' => 'TH', 'name' => 'Thailand', 'phone_code' => '66'],

            // Oceania
            ['iso_code' => 'AU', 'name' => 'Australia', 'phone_code' => '61'],
            ['iso_code' => 'NZ', 'name' => 'New Zealand', 'phone_code' => '64'],

            // South America
            ['iso_code' => 'BR', 'name' => 'Brazil', 'phone_code' => '55'],
            ['iso_code' => 'AR', 'name' => 'Argentina', 'phone_code' => '54'],
            ['iso_code' => 'CL', 'name' => 'Chile', 'phone_code' => '56'],
            ['iso_code' => 'CO', 'name' => 'Colombia', 'phone_code' => '57'],
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
        
        $this->command->info('Seeded ' . count($countries) . ' countries successfully.');
    }
}