<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programs & Community Outreach',
                'icon' => 'fas fa-hand-holding-heart',
                'description' => 'Staff involved in direct community engagement and project implementation.'
            ],
            [
                'name' => 'Education & Vocational Training',
                'icon' => 'fas fa-graduation-cap',
                'description' => 'Teaching, training, and curriculum development for our beneficiaries.'
            ],
            [
                'name' => 'Finance & Grant Management',
                'icon' => 'fas fa-file-invoice-dollar',
                'description' => 'Accounting, financial reporting, and managing donor funds.'
            ],
            [
                'name' => 'Logistics & Procurement',
                'icon' => 'fas fa-truck-loading',
                'description' => 'Supply chain management, transport, and equipment maintenance.'
            ],
            [
                'name' => 'Information Technology',
                'icon' => 'fas fa-laptop-code',
                'description' => 'IT support, system administration, and software development.'
            ],
            [
                'name' => 'Monitoring & Evaluation (M&E)',
                'icon' => 'fas fa-chart-line',
                'description' => 'Data collection and impact assessment of our NGO programs.'
            ],
            [
                'name' => 'Human Resources & Admin',
                'icon' => 'fas fa-users-cog',
                'description' => 'Staff recruitment, payroll, and general office operations.'
            ],
            [
                'name' => 'Health & Social Welfare',
                'icon' => 'fas fa-medkit',
                'description' => 'Medical assistance, counseling, and psychological support services.'
            ],
            [
                'name' => 'Fundraising & Communications',
                'icon' => 'fas fa-bullhorn',
                'description' => 'Public relations, social media, and securing new partnerships.'
            ],
        ];

        foreach ($categories as $category) {
            JobCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                    'description' => $category['description'],
                ]
            );
        }

        $this->command->info('Job Categories for Happy Family Rwanda have been seeded!');
    }
}