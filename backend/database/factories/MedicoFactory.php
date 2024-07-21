<?php

namespace Database\Factories;
use App\Models\Medico;
use App\Models\Persona;
use App\Models\Consultorio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medico>
 */
class MedicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Especialidad' => $this->faker->randomElement(['Cardiología', 'Dermatología', 'Neurología', 'Pediatría', 'Oftalmología']),
            'Subespecialidad' => $this->faker->randomElement(['Cardiología Intervencionista', 'Dermatopatología', 'Neurofisiología', 'Neonatología', 'Oftalmología Pediátrica']),
            'NumeroCarnet' => $this->faker->unique()->numerify('CARNET######'),
            'persona_id' => Persona::factory(),
            'consultorio_id' => 1,//Consultorio::factory(),
            'Estado' => 'Activo',
        ];
    }
}
