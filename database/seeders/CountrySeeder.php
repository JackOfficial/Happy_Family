<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear existing to avoid duplicates if necessary
        // Country::truncate(); 

        try {
            // Added a User-Agent and a longer timeout
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'Laravel-App-Seeder'
            ])
            ->timeout(60) 
            ->get('https://restcountries.com/v3.1/all');

            if ($response->successful()) {
                $countries = $response->json();

                foreach ($countries as $data) {
                    // Extracting phone code safely
                    $root = $data['idd']['root'] ?? '';
                    $suffix = $data['idd']['suffixes'][0] ?? '';
                    $fullPhoneCode = $root . $suffix;

                    Country::updateOrCreate(
                        ['iso_code' => $data['cca2']], 
                        [
                            'name' => $data['name']['common'],
                            'phone_code' => $fullPhoneCode ?: null,
                            'is_active' => true,
                        ]
                    );
                }
                
                $this->command->info('Countries seeded successfully!');
            } else {
                $this->command->error('API Request failed with status: ' . $response->status());
            }

        } catch (\Exception $e) {
            Log::error('Seeder Error: ' . $e->getMessage());
            $this->command->error('Error seeding countries: ' . $e->getMessage());
        }
    }
}