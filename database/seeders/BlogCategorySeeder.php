<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Community Outreach',
            'Education & Literacy',
            'Health & Wellness',
            'Sustainable Development',
            'Emergency Relief',
            'Environmental Conservation',
            'Youth Empowerment',
            'Human Rights Advocacy'
        ];

        foreach ($categories as $categoryName) {
            // Create the Category
            $category = BlogCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);

            // Create a dummy polymorphic photo record for each
            // Note: In a real scenario, you'd have these files in your storage
            $category->categoryPhoto()->create([
                'file_path' => 'uploads/categories/default-placeholder.jpg',
            ]);
        }
    }
}