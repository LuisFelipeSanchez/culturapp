<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campos de perfil extendido a la tabla users:
     * - Documento de identidad (tipo + número)
     * - Datos de contacto (teléfono, dirección)
     * - Fecha de nacimiento
     * - Foto de perfil
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('document_type', ['cc', 'ti', 'pasaporte', 'ce'])->nullable()->after('role');
            $table->string('document_number')->nullable()->after('document_type');
            $table->date('birth_date')->nullable()->after('document_number');
            $table->string('phone', 20)->nullable()->after('birth_date');
            $table->string('address')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['document_type', 'document_number', 'birth_date', 'phone', 'address', 'avatar']);
        });
    }
};
