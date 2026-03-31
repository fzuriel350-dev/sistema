<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Electrónica', 
            'Línea Blanca', 
            'Abarrotes', 
            'Cuidado Personal', 
            'Limpieza', 
            'Muebles', 
            'Deportes', 
            'Juguetes', 
            'Automotriz', 
            'Panadería'
        ];

        foreach ($categorias as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'descripcion' => 'Productos del departamento de ' . $nombre
            ]);
        }
    }
}