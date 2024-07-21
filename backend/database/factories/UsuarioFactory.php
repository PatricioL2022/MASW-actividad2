<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Usuario' => $this->faker->unique()->text(),
            'Password' => $this->faker->password(),
            'rol_id' => Rol::factory(),
            'persona_id' => Persona::factory(),
            'Estado' => $this->faker->randomElement(['Activo', 'Inactivo']),
        ];
    }
}
