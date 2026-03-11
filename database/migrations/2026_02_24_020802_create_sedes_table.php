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
    Schema::create('sedes', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('address');
        $table->enum('zone', ['urbana', 'rural']); // English names for the enum
        $table->text('description')->nullable();
        $table->decimal('latitude', 10, 8);
        $table->decimal('longitude', 11, 8);
        $table->string('image_url')->nullable();
        $table->json('contact_info')->nullable(); // Phone, email, social media
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedes');
    }
};
