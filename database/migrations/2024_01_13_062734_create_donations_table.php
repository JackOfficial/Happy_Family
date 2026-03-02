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
       Schema::create('donations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('donor_id')->nullable()->constrained()->cascadeOnDelete(); // optional donor
    $table->foreignId('project_id')->nullable()->constrained()->cascadeOnDelete(); // if donating to project
    $table->foreignId('event_id')->nullable()->constrained()->cascadeOnDelete(); // if donating for event
    $table->foreignId('fundraising_id')->nullable()->constrained()->cascadeOnDelete(); // optional future fundraising table

    $table->string('name')->nullable();
    $table->string('email')->nullable();
    $table->string('phone')->nullable();

    $table->decimal('amount', 12, 2);
    $table->string('currency', 10)->default('RWF');
    $table->string('payment_method')->nullable();
    $table->string('transaction_id')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
