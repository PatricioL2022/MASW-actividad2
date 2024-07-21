<?php

namespace App\Http\Controllers\API;

use App\Models\Horarioatenciondetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HorarioatenciondetalleController
{
    public function ListarHorarioatenciones()
    {
        $horarioatenciondetalles = Horarioatenciondetalle::all();
        $data = [
            'data' => $horarioatenciondetalles,
            'message' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }

    public function detalles($medico_id)
    {
       //$horario = Horarioatenciondetalle::where('medico_id','=',$medico_id)->with('medico')->get();
        $data = DB::table('horarioatenciondetalle')
            ->join('horarioatencion', 'horarioatenciondetalle.horarioatencion_id', '=', 'horarioatencion.id')
            ->join('medico', 'horarioatenciondetalle.medico_id', '=', 'medico.id')
            ->join('persona', 'medico.persona_id', '=', 'persona.id')
            ->select('persona.Nombres','persona.Apellidos','horarioatenciondetalle.id',
                'horarioatencion.Nombre','horarioatencion.HoraInicio','horarioatencion.HoraFin')
            ->where('medico_id', '=', $medico_id)
            ->get();
        $data = [
            'data' => $data,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);

    }

}
