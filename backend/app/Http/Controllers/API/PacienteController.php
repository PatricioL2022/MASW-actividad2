<?php

namespace App\Http\Controllers\API;

use App\Models\Paciente;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController
{
    public function ListarPacientes()
    {
        $Pacientes = Paciente::all();
        $data = [
            'data' => $Pacientes,
            'message' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }

    public function ListarPacientesPag($codigo, $rango)
    {
        $q = Paciente::join('persona', 'paciente.persona_id', '=', 'persona.id')
            ->select(
                'paciente.id',
                'paciente.NumeroExpediente',
                'paciente.persona_id',
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
                'paciente.Estado',
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
        $Paciente = Paciente::find($id);

        if (!$Paciente) {
            $data = [
                'message' => 'Paciente no encontrado',
                'status' => 404
            ];
            return response()->json($data);
        }

        $data = [
            'Paciente' => $Paciente,
            'status' => 200
        ];

        return response()->json($data);
    }
    public function Filtrar($tipo, $valor)
    {
        $query = Paciente::query();

        switch ($tipo) {

            case 0:
                $query->join('persona', 'paciente.persona_id', '=', 'persona.id')
                    ->where('paciente.Estado', $valor);
                break;
            case 1:
                $query->join('persona', 'paciente.persona_id', '=', 'persona.id')
                    ->where('persona.Identificacion', strtoupper($valor))
                    ->where('paciente.Estado', 'Activo');
                break;

            case 2:
                $query
                    ->join('persona', 'paciente.persona_id', '=', 'persona.id')
                    ->where('persona.Nombres', strtoupper($valor))
                    ->where('paciente.Estado', 'Activo');
                break;

            case 3:
                $query
                    ->join('persona', 'paciente.persona_id', '=', 'persona.id')
                    ->where('persona.Nombres', 'like', '%' . strtoupper($valor) . '%')
                    ->where('paciente.Estado', 'Activo');
                break;

            case 4:
                $query
                    ->join('persona', 'paciente.persona_id', '=', 'persona.id')
                    ->where('persona.Apellidos', strtoupper($valor))
                    ->where('paciente.Estado', 'Activo');
                break;

            case 5:
                $query
                    ->join('persona', 'paciente.persona_id', '=', 'persona.id')
                    ->where('persona.Apellidos', 'like', '%' . strtoupper($valor) . '%')
                    ->where('paciente.Estado', 'Activo');
                break;

            default:

                return response()->json([
                    'data' => [],
                    'exito' => 400,
                    'mensaje' => 'Tipo no válido'
                ]);
        }

        $result = $query->select(
            'paciente.id',
            'paciente.NumeroExpediente',
            'paciente.persona_id',
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
            'paciente.Estado'
        )
            ->orderBy('paciente.id', 'desc')->take(100)->get();

        $data = [
            'data' => $result,
            'message' => 'Paciente actualizado',
            'exito' => 200
        ];

        return response()->json($data);
    }


    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NumeroExpediente' => 'required|numeric|unique:paciente,NumeroExpediente',
            'Estado' => 'required|string',
            'persona_id' => 'required|numeric|unique:paciente,persona_id',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

        $Paciente = Paciente::create([
            'NumeroExpediente' => $request->NumeroExpediente,
            'Estado' => $request->Estado,
            'persona_id' => $request->persona_id,
        ]);

        if (!$Paciente) {
            $data = [
                'data' =>  '',
                'message' => 'Error al crear el estudiante',
                'exito' => 500
            ];
            return response()->json($data);
        }

        $data = [
            'data' =>  $Paciente,
            'message' => '',
            'exito' => 201
        ];

        return response()->json($data);
    }
    public function Editar(Request $request)
    {
        $Paciente = Paciente::find($request->id);

        if (!$Paciente) {
            $data = [
                'message' => 'Paciente no encontrado',
                'status' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'NumeroExpediente' => 'required|numeric',
            'Estado' => 'required|string',
            'persona_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

        $Paciente->NumeroExpediente = $request->NumeroExpediente;
        $Paciente->Estado = $request->Estado;
        $Paciente->persona_id = $request->persona_id;

        $Paciente->save();

        $data = [
            'data' =>  $Paciente,
            'message' => 'Paciente actualizado',
            'exito' => 200
        ];

        return response()->json($data);
    }

    public function EditarParcial(Request $request, $id)
    {
        $Paciente = Paciente::find($id);

        if (!$Paciente) {
            $data = [
                'data' =>  '',
                'message' => 'Paciente no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'NumeroExpediente' => 'numeric',
            'Estado' => 'string',
            'persona_id' => 'numeric',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data);
        }

        if ($request->has('NumeroExpediente')) {
            $Paciente->NumeroExpediente = $request->NumeroExpediente;
        }

        if ($request->has('Estado')) {
            $Paciente->Estado = $request->Estado;
        }
        if ($request->has('persona_id')) {
            $Paciente->persona_id = $request->persona_id;
        }


        $Paciente->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'Paciente' => $Paciente,
            'status' => 200
        ];

        return response()->json($data);
    }

    public function Eliminar($id)
    {

        $Paciente = Paciente::find($id);

        if (!$Paciente) {
            $data = [
                'mensaje' => 'Paciente no encontrada',
                'exito' => 404
            ];
            return response()->json($data);
        }

        try {
            $Paciente->delete();
            $data = [
                'mensaje' => 'Paciente eliminada',
                'exito' => 200
            ];
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'constraint violation') !== false) {
                $data = [
                    'mensaje' => 'Primary key en uso en otra entidad',
                    'exito' => 400
                ];
            } else {
                $data = [
                    'mensaje' => 'Error al eliminar la Paciente: ' . $e->getMessage(),
                    'exito' => 500
                ];
            }
        }

        return response()->json($data);
    }
}
