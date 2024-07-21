<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicoController extends Controller
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
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Especialidad' => 'required|max:100',
            'Subespecialidad' => 'required|max:100',
            'NumeroCarnet' => 'required|max:15',
            'IdPersona' => 'required',
            'IdConsultorio' => 'required',
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
            'IdPersona' => $request->IdPersona,
            'IdConsultorio' => $request->IdConsultorio,
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
            'IdPersona' => 'required',
            'IdConsultorio' => 'required',
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
        $Medico->IdPersona = $request->IdPersona;
        $Medico->IdConsultorio = $request->IdConsultorio;

        $Medico->save();

        $data = [
            'data' =>  $Medico,
            'message' => 'Medico actualizado',
            'exito' => 200
        ];

        return response()->json($data, 200);
    }
    public function EditarParcial(Request $request, $id)
    {
        $Medico = Medico::find($id);

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
            'IdPersona' => '',
            'IdConsultorio' => '',
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

        if ($request->has('IdPersona')) {
            $Medico->IdPersona = $request->IdPersona;
        }

        if ($request->has('IdConsultorio')) {
            $Medico->IdConsultorio = $request->IdConsultorio;
        }

        $Medico->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'Medico' => $Medico,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
