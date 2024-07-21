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
            'message' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }

    public function ListarMedicosPag($codigo, $rango)
    {
        $q = Medico::join('persona', 'medico.persona_id', '=', 'persona.id')
            ->join('consultorio', 'medico.consultorio_id', '=', 'consultorio.id')
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
                'medico.Estado',
            )
            ->orderBy('id', 'desc')
            ->skip($codigo)
            ->take($rango)
            ->get();

        $data = [
            'data' => $q,
            'message' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data);
    }
    public function BuscarId($id)
    {
        $Medico = Medico::find($id);

        if (!$Medico) {
            $data = [
                'message' => 'Medico no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'Medico' => $Medico,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function Filtrar($tipo, $valor)
    {
        $query = Medico::query();

        switch ($tipo) {

            case 0:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->where('medico.Estado', $valor);
                break;
            case 1:
                $query->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->where('persona.Identificacion', strtoupper($valor))
                    ->where('medico.Estado', 'Activo');
                break;

            case 2:
                $query
                    ->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->where('persona.Nombres', strtoupper($valor))
                    ->where('medico.Estado', 'Activo');
                break;

            case 3:
                $query
                    ->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->where('persona.Nombres', 'like', '%' . strtoupper($valor) . '%')
                    ->where('medico.Estado', 'Activo');
                break;

            case 4:
                $query
                    ->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->where('persona.Apellidos', strtoupper($valor))
                    ->where('medico.Estado', 'Activo');
                break;

            case 5:
                $query
                    ->join('persona', 'medico.persona_id', '=', 'persona.id')
                    ->where('persona.Apellidos', 'like', '%' . strtoupper($valor) . '%')
                    ->where('medico.Estado', 'Activo');
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
            'persona.Identificacion',
            'persona.Nombres',
            'persona.Apellidos',
            'persona.TipoIdentificacion',
            'persona.Genero',
            'persona.Direccion',
            'persona.Telefono',
            'persona.Correo',
            'persona.Titulo',
            'persona.FechaNacimiento',
            'persona.Foto',
            'persona.GrupoSanguineo',
            'medico.Estado'
        )
            ->orderBy('medico.id', 'desc')->take(100)->get();

        $data = [
            'data' => $result,
            'message' => 'medico actualizado',
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
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
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
                'message' => 'Error al crear el estudiante',
                'exito' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'data' =>  $Medico,
            'message' => '',
            'exito' => 201
        ];

        return response()->json($data, 201);
    }
    public function Editar(Request $request, $id)
    {
        $Medico = Medico::find($id);

        if (!$Medico) {
            $data = [
                'message' => 'Medico no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
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
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
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
            'message' => 'Medico actualizado',
            'exito' => 200
        ];

        return response()->json($data, 200);
    }
    public function EditarParcial(Request $request)
    {
        $Medico = Medico::find($request->id);

        if (!$Medico) {
            $data = [
                'data' =>  '',
                'message' => 'Medico no encontrado',
                'exito' => 404
            ];
            return response()->json($data, 404);
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
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
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

        return response()->json($data, 200);
    }
    public function Eliminar($id)
    {
        $Medico = Medico::find($id);

        if (!$Medico) {
            $data = [
                'message' => 'Medico no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Medico->delete();

        $data = [
            'message' => 'Medico eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
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
