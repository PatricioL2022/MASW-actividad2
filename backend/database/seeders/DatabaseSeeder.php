<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\agendadetalle;
use App\Models\Consultorio;
use App\Models\Horarioatenciondetalle;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Persona;
use App\Models\Horarioatencion;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Consultorio::factory()->count(1)->create();
        Medico::factory()->count(20)->create();
        Paciente::factory()->count(25)->create();

        Horarioatencion::factory()->create([
             'Nombre' => 'Diario',
             'HoraInicio' => '07:30',
             'HoraFin' => '17:30',
             'HoraInicioReceso' => '12:00',
             'HoraFinReceso' => '13:30',
         ]);

         Horarioatencion::factory()->create([
             'Nombre' => 'Medio día',
             'HoraInicio' => '07:30',
             'HoraFin' => '12:30',
             'HoraInicioReceso' => '00:00',
             'HoraFinReceso' => '00:00',
         ]);
         $arrayHorarioAtencion = array(1,2);
        for ($i = 1; $i <= 20; $i++) {
            Horarioatenciondetalle::factory()->create([
                'medico_id' => $i,
                'horarioatencion_id' => $arrayHorarioAtencion[array_rand($arrayHorarioAtencion)]
            ]);
         }
    }
}
