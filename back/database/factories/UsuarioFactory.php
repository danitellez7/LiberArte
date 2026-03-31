<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'rol' => $this->faker->randomElement(['admin', 'tutor', 'empleado']),
            
            // Campos opcionales
            'dni' => $this->faker->optional()->numerify('########A'),
            'telefono' => $this->faker->optional()->phoneNumber(),
            'direccion' => $this->faker->optional()->address(),

            // Campos automáticos
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}

