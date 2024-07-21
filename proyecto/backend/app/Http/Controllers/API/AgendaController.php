<?php

namespace App\Http\Controllers\API;

use App\Models\Agenda;
use App\Models\agendadetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AgendaController
{
    public function Agregar(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
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

             $this->AgregarDetalle($Agenda->id,$request->horarioatenciondetalle_id);
             $data = [
                 'data' =>  $Agenda,
                 'message' => '',
                 'exito' => 201
             ];
            DB::commit();
            return response()->json($data, 201);
        } catch (Throwable $e) {
            DB::rollBack();
            $data = [
                'data' =>  '',
                'message' => 'Error al crear la agenda: '.$e->getMessage(),
                'exito' => 500
            ];
            return response()->json($data, 500);
        }

    }

    function AgregarTiempo($times) {
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
    public function AgregarDetalle($agenda_id,$horarioatenciondetalle_id){
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
            $horaInicio = $this->AgregarTiempo($times);
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
                $horaInicio = $this->AgregarTiempo($times);
                $auxIntervalo = $this->obtenMinutos($horaInicio);
                $item = $times[0].'-'.$horaInicio;
                array_push($citas,$item);
                $minutosInicio = $auxIntervalo;//$this->obtenMinutos($auxIntervalo);
            }
        }

        foreach ($citas as $cita){
            list($hora_inicio, $hora_fin) = explode('-', $cita);
            $Agenda = agendadetalle::create([
                'agenda_id' => $agenda_id,
                'HoraInicio' => date("H:i",strtotime($hora_inicio)),
                'HoraFin' => date("H:i",strtotime($hora_fin)),
                'Estado' => "Disponible",
            ]);
        }
    }

    public function obtenHorarioDeAgenda($medico_id,$fecha){
        $data = DB::table('agendadetalle')
            ->join('agenda', 'agendadetalle.agenda_id', '=', 'agenda.id')
            ->join('horarioatenciondetalle', 'agenda.horarioatenciondetalle_id', '=', 'horarioatenciondetalle.id')
            ->select(
                DB::raw(
                    'agendadetalle.Id,
                           time_format(agendadetalle.HoraInicio,"%H:%i") HoraInicio,
                           time_format(agendadetalle.HoraFin,"%H:%i") HoraFin,
                           agendadetalle.Estado
                           ')
                 )
            ->where('agenda.Fecha', '=', $fecha)
            ->where('horarioatenciondetalle.medico_id', '=', $medico_id)
            ->get();
        $data = [
            'data' => $data,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }

}
