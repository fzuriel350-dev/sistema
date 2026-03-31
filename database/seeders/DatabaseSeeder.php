<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
 public function run(): void
    {
        $this->call([
            AdminUserSeeder::class, // 1. Creamos al dueño de los logs
            CategoriaSeeder::class, // 2. Creamos las categorías
            ProductoSeeder::class,  // 3. Creamos los productos (disparará el historial)
        ]);
    }
}
