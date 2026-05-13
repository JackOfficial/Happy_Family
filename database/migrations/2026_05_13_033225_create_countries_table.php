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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
    $table->string('name')->unique(); // e.g., "Rwanda"
    $table->string('iso_code', 3)->unique(); // e.g., "RW", "UG", "KE"
    $table->string('phone_code', 10)->nullable(); // e.g., "+250"
    $table->boolean('is_active')->default(true); // To limit the list to specific regions if needed
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
