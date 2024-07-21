<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;
    protected static ?string $password;
    public function definition(): array
    {
        return [
            'Usuario' => $this->faker->firstName,
            'Clave' => static::$password ??= Hash::make('password'),
            'Estado' => $this->faker->randomElement(['Activo', 'Inactivo']),
            'FechaIn' => $this->faker->date(),
            'persona_id' => Persona::factory(),
        ];
    }
}
