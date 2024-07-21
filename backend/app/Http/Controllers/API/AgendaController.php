<?php

namespace App\Http\Controllers\API;

use App\Models\Agenda;
use App\Models\agendadetalle;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgendaController
{
    public function Agregar(Request $request)
    {
        /*$validator = Validator::make($request->all(), [
            'Fecha' => 'required',
            'horarioatenciondetalle_id' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
        }

        $Agenda = Agenda::create([
            'Fecha' => $request->Fecha,
            'horarioatenciondetalle_id' => $request->horarioatenciondetalle_id
        ]);

        if (!$Agenda) {
            $data = [
                'data' =>  '',
                'message' => 'Error al crear la agenda',
                'exito' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'data' =>  $Agenda,
            'message' => '',
            'exito' => 201
        ];

        return response()->json($data, 201);*/
        return $this->AgregarDetalle(2);
    }

    function AddPlayTime($times) {

        $all_seconds=0;
        foreach ($times as $time) {

            list($hour, $minute) = explode(':', $time);
            $all_seconds += $hour * 3600;
            $all_seconds += $minute * 60;
            //$all_seconds += $second;

        }

        $total_minutes = floor($all_seconds/60);
        $seconds = $all_seconds % 60;
        $hours = floor($total_minutes / 60);
        $minutes = $total_minutes % 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public function obtenMinutos($tiempo){
       // $hora = 0;
        //$minuto = 0;
        $total_segundos = 0;
        list($hora, $minuto) = explode(':', $tiempo);
        $total_segundos += $hora * 3600;
        $total_segundos += $minuto * 60;
        $total_minutes = floor($total_segundos/60);
        return $total_minutes;
    }
    public function AgregarDetalle($horarioatenciondetalle_id){
        $intervalo_tiempo = "0:30"; //tiempo en minutos
        $data = DB::table('horarioatenciondetalle')
            ->join('horarioatencion', 'horarioatenciondetalle.horarioatencion_id', '=', 'horarioatencion.id')
            ->select('horarioatencion.HoraInicio','horarioatencion.HoraFin','horarioatencion.HoraInicioReceso',
            'horarioatencion.HoraFinReceso')
            ->where('horarioatenciondetalle.id', '=', $horarioatenciondetalle_id)
            ->first();

        $horaInicio = $data->HoraInicio;
        $horaFin = '';
        if($data->HoraInicioReceso=='00:00'){
            $horaFin = $data->HoraFin;

        }
       else {
           $horaFin = $data->HoraInicioReceso;

       }
        $minutosFin = $this->obtenMinutos($horaFin);
        $minutosInicio = $this->obtenMinutos($horaInicio);

        $citas = array();
        $auxIntervalo = 0;
        while ($minutosInicio < $minutosFin){
            $item = '';
            $times = array();
            $times[] = $horaInicio;
            $times[] = $intervalo_tiempo;
            $horaInicio = $this->AddPlayTime($times);
            $auxIntervalo = $this->obtenMinutos($horaInicio);
            $item = $times[0].'-'.$horaInicio;
            array_push($citas,$item);
            $minutosInicio = $auxIntervalo;
        }
        if($data->HoraInicioReceso!='00:00'){
            $horaInicio = $data->HoraFinReceso;
            $horaFin = $data->HoraFin;
            $minutosFin = $this->obtenMinutos($horaFin);
            $minutosInicio = $this->obtenMinutos($horaInicio);

            while ($minutosInicio < $minutosFin){
                $item = '';
                $times = array();
                $times[] = $horaInicio;
                $times[] = $intervalo_tiempo;
                $horaInicio = $this->AddPlayTime($times);
                $auxIntervalo = $this->obtenMinutos($horaInicio);
                $item = $times[0].'-'.$horaInicio;
                array_push($citas,$item);
                $minutosInicio = $auxIntervalo;//$this->obtenMinutos($auxIntervalo);
            }
        }

        $value = '';
        foreach ($citas as $cita){
            list($hora_inicio, $hora_fin) = explode('-', $cita);
            $Agenda = agendadetalle::create([
                'agenda_id' => 1,
                'HoraInicio' => date("H:i",strtotime($hora_inicio)),
                'HoraFin' => date("H:i",strtotime($hora_fin)),
                'Estado' => "Disponible",
            ]);
        }
        return $value;
        /**for ($i = $minutosInicio; $i < $minutosFin; $i+$auxIntervalo) {
            $item = '';
            $times = array();
            $times[] = $horaInicio;
            $times[] = $intervalo_tiempo;
            $horaInicio = $this->AddPlayTime($times);
            $auxIntervalo = $this->obtenMinutos($horaInicio);
            $item = $times[0].'-'.$horaInicio;
            array_push($citas,$item);
        }*/
       // return $citas;


        //return $data;
    }
}
