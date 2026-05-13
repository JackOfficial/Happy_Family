<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Relational Links
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->constrained(); // Removed cascade to keep data integrity of country list
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email'); // Consider adding ->index() if you'll search by email often
            $table->string('phone', 25);
            $table->string('gender')->nullable(); // Important for NGO diversity metrics
            $table->date('date_of_birth')->nullable(); // Optional: depending on HR requirements
            $table->string('address')->nullable();
            $table->string('city')->nullable(); // Separated for better filtering
            
            // Professional & Education
            $table->string('level_of_education')->nullable(); 
            $table->string('field_of_study')->nullable();
            $table->integer('years_of_experience')->nullable(); // Quick filter for HR
            
            // Recruitment Details
            $table->string('notice_period')->nullable(); 
            $table->decimal('desired_salary', 15, 2)->nullable();
            $table->string('currency', 5)->default('RWF'); // Flexibility for international vs local staff
            
            // Digital Footprint
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable(); // Useful for IT or Communications roles
            
            // Analytics
            $table->string('referral_source')->nullable(); // e.g., "LinkedIn", "Friend", "HFRO Website"
            
            $table->text('additional_notes')->nullable(); 

            // Application Status
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired', 'withdrawn'])
                  ->default('pending')
                  ->index(); // Indexed for faster dashboard loading

            $table->timestamps();
            $table->softDeletes();
            $table->unique(['job_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};