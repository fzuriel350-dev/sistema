<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'nombre' => fake()->unique()->word(), // Genera un nombre único [cite: 28, 30]
        'descripcion' => fake()->sentence(8), // Genera la descripción de 8 palabras [cite: 29, 30]
    ];
}
}
