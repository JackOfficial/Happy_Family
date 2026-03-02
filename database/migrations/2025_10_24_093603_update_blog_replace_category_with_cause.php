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
        Schema::table('blogs', function (Blueprint $table) {
            // Drop the old foreign key and column safely
            if (Schema::hasColumn('blogs', 'blog_category_id')) {
                $table->dropForeign(['blog_category_id']);
                $table->dropColumn('blog_category_id');
            }

            // Add the new cause_id column and foreign key
            if (!Schema::hasColumn('blogs', 'cause_id')) {
                $table->foreignId('cause_id')
                      ->after('user_id')
                      ->constrained()
                      ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Rollback logic (restore blog_category_id)
            if (Schema::hasColumn('blogs', 'cause_id')) {
                $table->dropForeign(['cause_id']);
                $table->dropColumn('cause_id');
            }

            if (!Schema::hasColumn('blogs', 'blog_category_id')) {
                $table->foreignId('blog_category_id')
                      ->after('user_id')
                      ->constrained()
                      ->cascadeOnDelete();
            }
        });
    }
};
