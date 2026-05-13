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
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            
            // The name of the category (e.g., "Health Support", "Education", "Administration")
            $table->string('name')->unique();
            
            // For clean URLs and filtering
            $table->string('slug')->unique();
            
            // Optional: A short description of what this department does
            $table->text('description')->nullable();
            
            // Optional: Icon class (FontAwesome) if you want to show icons next to categories
            $table->string('icon')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_categories');
    }
};