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
      Schema::create('stories', function (Blueprint $table) {
       $table->id();
    $table->string('title');
    $table->string('slug')->unique(); // SEO-friendly URL
    $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->text('summary')->nullable();
    $table->longText('content');
    $table->enum('status', ['draft', 'published', 'archived'])->default('published'); // controlled statuses
    $table->timestamps();
    $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
