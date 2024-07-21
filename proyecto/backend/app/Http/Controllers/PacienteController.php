<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
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
    }    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NumeroExpediente' => 'required|numeric',
            'IdPersona' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
        }

        $Paciente = Paciente::create([
            'NumeroExpediente' => $request->NumeroExpediente,
            'IdPersona' => $request->IdPersona,
        ]);

        if (!$Paciente) {
            $data = [
                'data' =>  '',
                'message' => 'Error al crear el estudiante',
                'exito' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'data' =>  $Paciente,
            'message' => '',
            'exito' => 201
        ];

        return response()->json($data, 201);
    }
    public function BuscarId($id)
    {
        $Paciente = Paciente::find($id);

        if (!$Paciente) {
            $data = [
                'message' => 'Paciente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'Paciente' => $Paciente,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
   public function Eliminar($id)
    {
        $Paciente = Paciente::find($id);

        if (!$Paciente) {
            $data = [
                'message' => 'Paciente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Paciente->delete();

        $data = [
            'message' => 'Paciente eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function Editar(Request $request, $id)
    {
        $Paciente = Paciente::find($id);

        if (!$Paciente) {
            $data = [
                'message' => 'Paciente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'NumeroExpediente' => 'required|numeric',
            'IdPersona' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
        }

        $Paciente->NumeroExpediente = $request->NumeroExpediente;
        $Paciente->IdPersona = $request->IdPersona;

        $Paciente->save();
        
        $data = [
            'data' =>  $Paciente,
            'message' => 'Paciente actualizado',
            'exito' => 200
        ];

        return response()->json($data, 200);
    }    public function EditarParcial(Request $request, $id)
    {
        $Paciente = Paciente::find($id);

        if (!$Paciente) {
            $data = [
                'data' =>  '',
                'message' => 'Paciente no encontrado',
                'exito' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'NumeroExpediente' => 'numeric',
            'IdPersona' => 'numeric',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('NumeroExpediente')) {
            $Paciente->NumeroExpediente = $request->NumeroExpediente;
        }

        if ($request->has('IdPersona')) {
            $Paciente->IdPersona = $request->IdPersona;
        }


        $Paciente->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'Paciente' => $Paciente,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
