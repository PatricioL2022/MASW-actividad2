<?php

namespace App\Http\Controllers\API;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MedicoController
{
    public function ListarMedicos()
    {
        $Medicos = Medico::all();
        $data = [
            'data' => $Medicos,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data);
    }

    public function ListarMedicosPag($codigo, $rango)
    {
        $q = Medico::join('persona', 'medico.persona_id', '=', 'persona.id')
            ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
            ->where('medico.Estado', 'Activo')
            ->select(
                'medico.id',
                'medico.Especialidad',
                'medico.Subespecialidad',
                'medico.NumeroCarnet',
                'persona.Identificacion',
                'persona.Nombres',
                'persona.Apellidos',
                'persona.Genero',
                'persona.Telefono',
                'persona.Correo',
                'persona.FechaNacimiento',
                'consultorio.Nombre',
                'consultorio.Ruc',
                'consultorio.NombreComercial',
                'consultorio.Direccion',
                'consultorio.Telefono',
                'consultorio.DireccionMatriz',
                'medico.persona_id',
                'medico.consultorio_id',
                'medico.Estado',
            )
            ->orderBy('id', 'desc')
            ->skip($codigo)
            ->take($rango)
            ->get();

        $data = [
            'data' => $q,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data);
    }
    public function BuscarId($id)
    {
        $Medico = Medico::find($id);

        if (!$Medico) {
            $data = [
                'mensaje' => 'Medico no encontrado',
                'status' => 404
            ];
            return response()->json($data);
        }

        $data = [
            'Medico' => $Medico,
            'status' => 200
        ];

        return response()->json($data);
    }
    public function Filtrar($tipo, $valor)
    {
        $query = Medico::query();

        switch ($tipo) {

            case 0:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
                    ->where('medico.Estado', $valor);
                break;
            case 1:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
                    ->where('persona.Identificacion', strtoupper($valor));
                break;

            case 2:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
                    ->where('persona.Nombres', strtoupper($valor));
                break;

            case 3:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
                    ->where('persona.Nombres', 'like', '%' . strtoupper($valor) . '%');
                break;

            case 4:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
                    ->where('persona.Apellidos', strtoupper($valor));
                break;

            case 5:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
                    ->where('persona.Apellidos', 'like', '%' . strtoupper($valor) . '%');
                break;

            default:

                return response()->json([
                    'data' => [],
                    'exito' => 400,
                    'mensaje' => 'Tipo no válido'
                ]);
        }

        $result = $query->select(
            'medico.id',
            'medico.NumeroCarnet',
            'medico.persona_id',
            'medico.Especialidad',
            'medico.Subespecialidad',
            'persona.Identificacion',
            'persona.Nombres',
            'persona.Apellidos',
            'persona.Genero',
            'persona.Telefono',
            'persona.Correo',
            'persona.FechaNacimiento',
            'consultorio.Nombre',
            'consultorio.Ruc',
            'consultorio.NombreComercial',
            'consultorio.Direccion',
            'consultorio.Telefono',
            'consultorio.DireccionMatriz',
            'medico.persona_id',
            'medico.consultorio_id',
            'medico.Estado',
        )
            ->orderBy('medico.id', 'desc')->take(100)->get();

        $data = [
            'data' => $result,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Especialidad' => 'required|max:100',
            'Subespecialidad' => 'required|max:100',
            'NumeroCarnet' => 'required|max:15',
            'persona_id' => 'required|unique:medico,NumeroCarnet',
            'consultorio_id' => 'required',
            'Estado' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'mensaje' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

        $Medico = Medico::create([
            'Especialidad' => $request->Especialidad,
            'Subespecialidad' => $request->Subespecialidad,
            'NumeroCarnet' => $request->NumeroCarnet,
            'persona_id' => $request->persona_id,
            'consultorio_id' => $request->consultorio_id,
            'Estado' => $request->Estado,
        ]);

        if (!$Medico) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Error al crear el registro',
                'exito' => 500
            ];
            return response()->json($data);
        }

        $data = [
            'data' =>  $Medico,
            'mensaje' => '',
            'exito' => 201
        ];

        return response()->json($data);
    }
    public function Editar(Request $request)
    {
        $Medico = Medico::find($request->id);

        if (!$Medico) {
            $data = [
                'mensaje' => 'Medico no encontrado',
                'status' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Especialidad' => 'required|max:100',
            'Subespecialidad' => 'required|max:100',
            'NumeroCarnet' => 'required|max:15',
            'persona_id' => 'required',
            'consultorio_id' => 'required',
            'Estado' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'mensaje' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

        $Medico->Especialidad = $request->Especialidad;
        $Medico->Subespecialidad = $request->Subespecialidad;
        $Medico->NumeroCarnet = $request->NumeroCarnet;
        $Medico->persona_id = $request->persona_id;
        $Medico->consultorio_id = $request->consultorio_id;
        $Medico->Estado = $request->Estado;

        $Medico->save();

        $data = [
            'data' =>  $Medico,
            'mensaje' => 'Medico actualizado',
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function EditarParcial(Request $request)
    {
        $Medico = Medico::find($request->id);

        if (!$Medico) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Medico no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Especialidad' => 'max:100',
            'Subespecialidad' => 'max:100',
            'NumeroCarnet' => 'max:15',
            'persona_id' => '',
            'consultorio_id' => '',
            'Estado' => '',
        ]);

        if ($validator->fails()) {
            $data = [
                'mensaje' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data);
        }

        if ($request->has('Especialidad')) {
            $Medico->Especialidad = $request->Especialidad;
        }

        if ($request->has('Subespecialidad')) {
            $Medico->Subespecialidad = $request->Subespecialidad;
        }

        if ($request->has('NumeroCarnet')) {
            $Medico->NumeroCarnet = $request->NumeroCarnet;
        }

        if ($request->has('persona_id')) {
            $Medico->persona_id = $request->persona_id;
        }

        if ($request->has('consultorio_id')) {
            $Medico->consultorio_id = $request->consultorio_id;
        }
        if ($request->has('Estado')) {
            $Medico->Estado = $request->Estado;
        }

        $Medico->save();

        $data = [
            'message' => 'Medico actualizado',
            'Medico' => $Medico,
            'status' => 200
        ];

        return response()->json($data);
    }
    public function Eliminar($id)
    {
        $Medico = Medico::find($id);

        if (!$Medico) {
            $data = [
                'mensaje' => 'Medico no encontrado',
                'status' => 404
            ];
            return response()->json($data);
        }

        $Medico->delete();

        $data = [
            'mensaje' => 'Medico eliminada',
            'status' => 200
        ];

        return response()->json($data);
    }
    public function ListarMedicosConEspecialidad()
    {
        $data = DB::table('medico')
            ->join('persona', 'medico.persona_id', '=', 'persona.id')
            ->select('persona.Nombres','persona.Apellidos','medico.id',
                'medico.Especialidad','persona.Titulo','persona.Foto')
            ->where('persona.Estado', '=', 'Activo')
            ->get();
        $data = [
            'data' => $data,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }
}
