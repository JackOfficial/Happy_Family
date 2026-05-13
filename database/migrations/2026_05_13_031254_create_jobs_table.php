<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->string('title');
            $table->string('slug')->unique(); // For SEO friendly URLs: happyfamilyrwanda.org/careers/social-worker
            
            // Categorization
            // Note: Ensure you have a job_categories table or change this to string if preferred
            $table->foreignId('job_category_id')->constrained()->onDelete('cascade');
            
            // Content
            $table->longText('description'); // The main job details
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable(); // NGO specific: Insurance, transport, etc.
            
            // Metadata
            $table->string('location')->default('Kigali, Rwanda');
            $table->enum('type', ['Full-time', 'Part-time', 'Contract', 'Volunteer', 'Internship'])
                  ->default('Full-time');
            
            // Status & Deadlines
            $table->boolean('is_active')->default(true);
            $table->dateTime('deadline')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Highly recommended for audit trails in NGOs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};