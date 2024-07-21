<?php

namespace App\Http\Controllers\API;

use App\Models\agendadetalle;
use App\Models\Cita;
use App\Models\Consultorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CitaController
{
    public function Agregar(Request $request)
    {
        try {
            DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'agendadetalle_id' => 'required',
            'paciente_id' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
        }

        $Cita = Cita::create([
            'agendadetalle_id' => $request->agendadetalle_id,
            'Tipo' => 'Agendado',
            'Estado' => 'Pendiente',
            'Descripcion' => 'Cita agendada',
            'paciente_id' => $request->paciente_id
        ]);
        $AgendaDetalle = AgendaDetalle::find($request->agendadetalle_id);
        $AgendaDetalle->Estado = 'No Disponible';
        $AgendaDetalle->save();

        if (!$Cita) {
            $data = [
                'data' =>  '',
                'message' => 'Error al registrar la cita',
                'exito' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'data' =>  $Cita,
            'message' => '',
            'exito' => 201
        ];
        DB::commit();
        return response()->json($data, 201);
        } catch (Throwable $e) {
            DB::rollBack();
            $data = [
                'data' =>  '',
                'message' => 'Error al crear la cita: '.$e->getMessage(),
                'exito' => 500
            ];
            return response()->json($data, 500);
        }
    }
    public function ObtenCitasDeMedico($medico_id){
        $data = DB::table('cita')
        ->join('agendadetalle', 'cita.agendadetalle_id', '=', 'agendadetalle.id')
        ->join('paciente', 'cita.paciente_id', '=', 'paciente.id')
        ->join('persona', 'paciente.persona_id', '=', 'persona.id')
        ->join('agenda', 'agendadetalle.agenda_id', '=', 'agenda.id')
        ->join('horarioatenciondetalle', 'agenda.horarioatenciondetalle_id', '=', 'horarioatenciondetalle.id')
        ->select('cita.id','persona.Nombres','persona.Apellidos','agendadetalle.HoraInicio','agendadetalle.HoraFin',
        'agenda.Fecha')
        ->where('horarioatenciondetalle.medico_id', '=', $medico_id)
        ->first();
    }
}
