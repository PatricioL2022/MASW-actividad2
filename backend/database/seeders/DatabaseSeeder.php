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
        Persona::factory()->count(50)->create();
        Consultorio::factory()->count(5)->create();
        Medico::factory()->count(10)->create();
        Paciente::factory()->count(25)->create();

        Horarioatencion::factory()->create([
             'Nombre' => 'Diario',
             'HoraInicio' => '07:30',
             'HoraFin' => '05:30',
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
        Horarioatenciondetalle::factory()->create([
            'medico_id' => 1,
            'horarioatencion_id' => 1
        ]);
        Horarioatenciondetalle::factory()->create([
            'medico_id' => 2,
            'horarioatencion_id' => 2
        ]);
        Agenda::factory()->create([
            'Fecha' => date("Y-m-d",strtotime("2024/07/15")),
            'horarioatenciondetalle_id' => 1
        ]);
        Agenda::factory()->create([
            'Fecha' => date("Y-m-d",strtotime("2024/07/16")),
            'horarioatenciondetalle_id' => 1
        ]);
        Agenda::factory()->create([
            'Fecha' => date("Y-m-d",strtotime("2024/07/17")),
            'horarioatenciondetalle_id' => 1
        ]);
        Agenda::factory()->create([
            'Fecha' => date("Y-m-d",strtotime("2024/07/18")),
            'horarioatenciondetalle_id' => 1
        ]);
        Agenda::factory()->create([
            'Fecha' => date("Y-m-d",strtotime("2024/07/19")),
            'horarioatenciondetalle_id' => 1
        ]);

        agendadetalle::factory()->create([
            'agenda_id' => 1,
            'HoraInicio' => date("H:i",strtotime("07:30")),
            'HoraFin' => date("H:i",strtotime("8:00")),
            'Estado' => 'Disponible'
        ]);
        agendadetalle::factory()->create([
            'agenda_id' => 1,
            'HoraInicio' => date("H:i",strtotime("08:00")),
            'HoraFin' => date("H:i",strtotime("8:30")),
            'Estado' => 'Disponible'
        ]);
        agendadetalle::factory()->create([
            'agenda_id' => 1,
            'HoraInicio' => date("H:i",strtotime("08:30")),
            'HoraFin' => date("H:i",strtotime("09:00")),
            'Estado' => 'Disponible'
        ]);

        Usuario::factory()->create([
            'Usuario' => 'admin',
            'Clave' => Hash::make('password'), // contraseña
            'Estado' => 'Activo',
            'FechaIn' => now(),
            'persona_id' => 1, // Asume que tienes registros en la tabla PERSONA
        ]);

    }
}
