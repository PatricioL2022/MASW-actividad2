<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        return [
            'Identificacion' => $this->faker->unique()->numerify('##########'),
            'TipoIdentificacion' => $this->faker->randomElement(['CI', 'PAS', 'RUC']),
            'Nombres' => $this->faker->firstName,
            'Apellidos' => $this->faker->lastName,
            'Genero' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'Telefono' => $this->faker->phoneNumber,
            'Direccion' => $this->faker->address,
            'Correo' => $this->faker->unique()->safeEmail,
            'GrupoSanguineo' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'Titulo' => 'Dr.',
            'FechaNacimiento' => $this->faker->date(),
            'Foto' => $this->faker->imageUrl(100, 100, 'people'),
            'Estado' => $this->faker->randomElement(['Activo', 'Inactivo']),
        ];
    }
}
