<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * El password actual utilizado por el factory.
     */
    protected static ?string $password;

    /**
     * Define el estado por defecto del modelo.
     * Ajustado específicamente para la tabla 'usuarios'.
     */
    public function definition(): array
    {
        return [
            // 'nombre' evita el QueryException de "no column named name"
            'nombre'         => fake()->name(), 
            'email'          => fake()->unique()->safeEmail(),
            'password'       => static::$password ??= Hash::make('password'),
            'rol'            => 'usuario', // Valor por defecto para las pruebas de autorizacion [cite: 79]
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Estado para usuarios sin verificar.
     * Se deja vacío ya que tu tabla no cuenta con la columna email_verified_at.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => []);
    }
}
