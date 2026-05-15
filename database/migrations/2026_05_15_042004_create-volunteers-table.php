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
        Schema::table('volunteers', function (Blueprint $table) {
            $table->id();
    // Use nullable if they can apply before creating an account
    $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
    
    // Link to your existing countries table
    $table->foreignId('country_id')->nullable()->constrained();

    // Basic Info (useful if user_id is null)
    $table->string('full_name')->nullable();
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->date('dob')->nullable();
    
    // Professional Info
    $table->string('occupation')->nullable();
    $table->text('skills')->nullable(); // or JSON
    $table->text('reason')->nullable(); // Why do they want to join HFRO?
    
    // Status & Admin
    $table->enum('status', ['pending', 'active', 'inactive', 'rejected'])->default('pending')->index();
    
    $table->timestamps();
    $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
