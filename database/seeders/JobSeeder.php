<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch categories to link them
        $categories = JobCategory::all()->pluck('id', 'name');

        if ($categories->isEmpty()) {
            $this->command->error('Please run JobCategorySeeder first!');
            return;
        }

        $vacancies = [
            [
                'title' => 'Senior Program Coordinator',
                'category' => 'Programs & Community Outreach',
                'type' => 'Full-time',
                'location' => 'Kigali, Rwanda',
                'description' => 'We are seeking a dedicated professional to oversee our community development initiatives in the Northern Province.',
                'requirements' => "• Master's degree in Social Work or related field.\n• 5+ years experience in NGO project management.\n• Fluency in Kinyarwanda and English.",
                'benefits' => "• Competitive NGO salary scale.\n• Comprehensive health insurance.\n• Professional development opportunities.",
                'deadline' => Carbon::now()->addDays(21),
            ],
            [
                'title' => 'Finance & Compliance Officer',
                'category' => 'Finance & Grant Management',
                'type' => 'Full-time',
                'location' => 'Kigali, Rwanda',
                'description' => 'Responsible for maintaining rigorous financial standards and ensuring compliance with international donor regulations.',
                'requirements' => "• CPA or ACCA qualification.\n• Experience with QuickBooks or similar ERPs.\n• Strong analytical and reporting skills.",
                'benefits' => "• Transport allowance.\n• 13th-month salary bonus.\n• Flexible working hours.",
                'deadline' => Carbon::now()->addDays(14),
            ],
            [
                'title' => 'Community Social Work Intern',
                'category' => 'Health & Social Welfare',
                'type' => 'Internship',
                'location' => 'Kigali, Rwanda',
                'description' => 'A learning opportunity for recent graduates to assist our social welfare team in home visitations and case management.',
                'requirements' => "• Recent graduate in Psychology or Social Work.\n• Strong empathy and communication skills.\n• Willingness to travel to rural areas.",
                'benefits' => "• Monthly transport stipend.\n• Mentorship from senior specialists.\n• Certificate of completion.",
                'deadline' => Carbon::now()->addDays(30),
            ],
            [
                'title' => 'Monitoring & Evaluation (M&E) Specialist',
                'category' => 'Monitoring & Evaluation (M&E)',
                'type' => 'Contract',
                'location' => 'Kigali, Rwanda',
                'description' => 'Leading the data collection and impact analysis for our 2026 Maternal Health project.',
                'requirements' => "• Proven track record in data analysis and M&E frameworks.\n• Proficiency in SPSS or STATA.\n• Experience writing technical donor reports.",
                'benefits' => "• Project-based performance bonuses.\n• High-impact work environment.",
                'deadline' => Carbon::now()->addDays(10),
            ],
            [
                'title' => 'Field Support Volunteer',
                'category' => 'Programs & Community Outreach',
                'type' => 'Volunteer',
                'location' => 'Kigali, Rwanda',
                'description' => 'Join our team to support logistics during our monthly community outreach programs.',
                'requirements' => "• Passion for community service.\n• Fluency in Kinyarwanda.\n• Good organizational skills.",
                'benefits' => "• Daily lunch and transport during field days.\n• Training in community engagement.",
                'deadline' => Carbon::now()->addMonths(2),
            ],
        ];

        foreach ($vacancies as $v) {
            // Find the category ID by name
            $categoryId = $categories[$v['category']] ?? $categories->first();

            Job::create([
                'title' => $v['title'],
                'slug' => Str::slug($v['title']) . '-' . Str::lower(Str::random(6)),
                'job_category_id' => $categoryId,
                'description' => $v['description'],
                'requirements' => $v['requirements'],
                'benefits' => $v['benefits'],
                'location' => $v['location'],
                'type' => $v['type'],
                'deadline' => $v['deadline'],
                'is_active' => true,
            ]);
        }

        $this->command->info('Job vacancies for Happy Family Rwanda have been successfully seeded.');
    }
}