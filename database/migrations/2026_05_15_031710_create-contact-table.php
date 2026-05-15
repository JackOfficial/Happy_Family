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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            
            // REMOVED unique() so one user can contact you multiple times
            $table->string('email')->index(); 
            
            $table->string('phone')->nullable();
            $table->string('subject')->nullable(); // Useful for sorting messages
            $table->text('message');
            
            // Status for your admin workflow
            $table->enum('status', ['active', 'resolved', 'archived'])->default('active')->index();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};