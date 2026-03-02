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
   Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
    $table->foreignId('cause_id')->nullable()->constrained()->cascadeOnDelete();

    $table->string('title');
    $table->string('slug')->unique(); // SEO friendly URL
    $table->text('summary')->nullable();
    $table->longText('description')->nullable();
    $table->text('goal')->nullable(); // optional
    $table->integer('beneficiaries')->nullable(); // optional
    $table->decimal('budget', 15, 2)->nullable();
    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();
    $table->unsignedTinyInteger('progress')->default(0)->comment('0–100% completion');
    $table->enum('status', ['active', 'completed', 'paused', 'cancelled'])->default('active');
    $table->timestamps();
    $table->softDeletes();
});
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
