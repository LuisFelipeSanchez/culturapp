<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el Super Administrador (Tú)
        User::updateOrCreate(
            ['email' => 'admin@culturapp.com'],
            [
                'name' => 'Luis Felipe Sanchez Moscoso',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Opcional: Crear un Administrador de prueba para una sede
        User::updateOrCreate(
            ['email' => 'gestor_chipre@culturapp.com'],
            [
                'name' => 'Gestor Cultural Chipre',
                'password' => Hash::make('chipre123'),
                'role' => 'admin',
                'sede_id' => 6, // Casa de la Cultura Chipre
                'email_verified_at' => now(),
            ]
        );
    }
}
