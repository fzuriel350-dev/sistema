<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Corre las semillas de la base de datos.
     */
    public function run(): void
    {
        // Creamos tu usuario administrador
        User::create([
            'name' => 'Zuriel Flores Fuentes',
            'email' => 'zurielflores@gmail.com',
            'password' => Hash::make('12345'),
            'rol' => 'admin',
        ]);

        $this->command->info('¡Usuario Administrador creado con éxito!');
    }
}