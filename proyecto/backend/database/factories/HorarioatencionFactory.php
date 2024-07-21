<?php

namespace Database\Factories;

use App\Models\Horarioatencion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horarioatencion>
 */
class HorarioatencionFactory extends Factory
{
    protected $model = Horarioatencion::class;

    public function definition()
    {
        return [
            'Nombre' => $this->faker->randomElement(['Normal', 'Fin de Semana']),
            'HoraInicio' => $this->faker->randomElement(['08:00','09:00']),
            'HoraFin' => $this->faker->randomElement(['17:00','18:00']),
            'HoraInicioReceso' => $this->faker->randomElement(['12:00','13:00']),
            'HoraFinReceso' => $this->faker->randomElement(['13:00','14:00']),
        ];
    }
}
