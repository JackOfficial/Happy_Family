<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('events', function (Blueprint $table) {
        // Add the cause relation
        $table->foreignId('cause_id')
              ->nullable()
              ->after('id') // Optional: keeps the DB organized
              ->constrained('causes')
              ->onDelete('set null');

        // Add user tracking columns
        $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('events', function (Blueprint $table) {
        // Drop foreign keys first to avoid integrity constraint errors
        $table->dropForeign(['cause_id']);
        $table->dropForeign(['created_by']);
        $table->dropForeign(['updated_by']);

        // Then drop the columns
        $table->dropColumn(['cause_id', 'created_by', 'updated_by']);
    });
}
};
