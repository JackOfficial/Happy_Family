<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        // Option A: Fetch from a reliable API/GitHub source
        // This ensures you get all ~195-250 regions/countries
        $response = Http::get('https://restcountries.com/v3.1/all');
        
        if ($response->successful()) {
            $countries = $response->json();

            foreach ($countries as $data) {
                Country::updateOrCreate(
                    ['iso_code' => $data['cca2']], // ISO 3166-1 alpha-2
                    [
                        'name' => $data['name']['common'],
                        'phone_code' => ($data['idd']['root'] ?? '') . ($data['idd']['suffixes'][0] ?? ''),
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}