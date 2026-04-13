<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the pivot table for Many-to-Many Causes
        Schema::create('cause_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cause_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // 2. Update the Projects table
        Schema::table('projects', function (Blueprint $table) {
            // Add duration and tracking columns
            $table->dropColumn(['goal', 'beneficiaries', 'summary']);
            $table->string('duration')->nullable()->after('end_date');
            $table->foreignId('created_by')->nullable()->after('updated_at')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();

            // Handle the Status change
            // Since modifying ENUMS can be tricky in some DB engines, 
            // we change it to a string to allow "Upcoming", "Ongoing", "Completed"
            $table->string('status')->default('Upcoming')->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cause_project');

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['duration', 'created_by', 'updated_by']);
            
            // Revert status to an enum if needed
            $table->enum('status', ['active', 'completed', 'paused', 'cancelled', 'planned'])
                  ->default('active')
                  ->change();
        });
    }
};