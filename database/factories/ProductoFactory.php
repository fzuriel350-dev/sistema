<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'nombre' => fake()->unique()->words(3, true), // [cite: 39]
        'descripcion' => fake()->paragraph(2), // [cite: 43]
        'precio' => fake()->randomFloat(2, 10, 5000), // [cite: 46]
        'stock' => fake()->numberBetween(0, 200), // [cite: 47]
        'categoria_id' => \App\Models\Categoria::factory(), // Crea una categoría si no existe [cite: 48]
    ];
}
}
