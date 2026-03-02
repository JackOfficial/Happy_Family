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
        Schema::create('applications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('career_id')->constrained()->cascadeOnDelete();
    $table->foreignId('country_id')->constrained()->cascadeOnDelete();
    
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email');
    $table->string('phone', 20);
    $table->string('address')->nullable();
    $table->string('level_of_education')->nullable();
    $table->string('field_of_study')->nullable();
    $table->string('notice_period')->nullable();
    $table->decimal('desired_salary', 15, 2)->nullable();
    $table->string('resume');
    $table->string('cover_letter')->nullable();
    $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected'])->default('pending');
    $table->timestamps();
     $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
