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
        // Add "pending" to the status enum
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE enrollments MODIFY status ENUM('enrolled', 'pending', 'approved', 'failed', 'dropped') DEFAULT 'enrolled'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE enrollments MODIFY status ENUM('enrolled', 'approved', 'failed', 'dropped') DEFAULT 'enrolled'");
    }
};
