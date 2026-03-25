<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Agregamos categorías de prueba
    \App\Models\Categoria::create(['nombre' => 'Electrónica', 'descripcion' => 'Equipos y accesorios']);
    \App\Models\Categoria::create(['nombre' => 'Ropa', 'descripcion' => 'Prendas de vestir']);
    \App\Models\Categoria::create(['nombre' => 'Alimentos', 'descripcion' => 'Comida y bebidas']);
    \App\Models\Categoria::create(['nombre' => 'Hogar', 'descripcion' => 'Muebles y decoración']);
}
}
