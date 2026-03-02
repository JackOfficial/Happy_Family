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
       Schema::create('events', function (Blueprint $table) {
        $table->id(); 
        $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
        $table->string('title'); 
        $table->longText('description')->nullable();
        $table->string('location')->nullable();
        $table->date('date')->nullable();
        $table->time('time')->nullable();
        $table->string('link')->nullable(); 
        $table->string('status')->default('active'); 
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
