<?php

namespace Database\Factories;

use App\Models\Consultorio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsultorioFactory extends Factory
{
    protected $model = Consultorio::class;

    public function definition()
    {
        return [
            'Nombre' => $this->faker->company,
            'Ruc' => $this->faker->unique()->numerify('###########'),
            'NombreComercial' => $this->faker->company,
            'Direccion' => $this->faker->address,
            'Telefono' => $this->faker->phoneNumber,
            'PorcentajeIva' => $this->faker->randomFloat(2, 0, 100),
            'Logo' => $this->faker->imageUrl(100, 100, 'business'),
            'Correo' => $this->faker->unique()->safeEmail,
            'DireccionMatriz' => $this->faker->address,
            'Estado' => $this->faker->randomElement(['Activo', 'Inactivo']),
        ];
    }
}
