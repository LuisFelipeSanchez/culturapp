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
        // Delete duplicate enrollments, keeping only the latest one per user+course
        \DB::statement('
            DELETE e1 FROM enrollments e1
            INNER JOIN enrollments e2
            WHERE e1.id < e2.id
              AND e1.user_id = e2.user_id
              AND e1.course_id = e2.course_id
        ');

        Schema::table('enrollments', function (Blueprint $table) {
            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'course_id']);
        });
    }
};
