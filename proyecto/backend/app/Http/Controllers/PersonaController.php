<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PersonaController extends Controller
{
    public function ListarPersonas()
    {
        $personas = Persona::all();
        $data = [
            'data' => $personas,
            'message' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdPersona' => 'required',
            'TipoIdPersona' => 'required',
            'Nombres' => 'required',
            'Apellidos' => 'required',
            'Genero' => 'required',
            'Telefono' => 'required',
            'Direccion' => 'required',
            'Correo' => 'required|email',
            'GrupoSanguineo' => 'required',
            'Titulo' => 'required',
            'FechaNacimiento' => 'required',
            'Foto' => 'required',
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

        $persona = Persona::create([
            'IdPersona' => $request->IdPersona,
            'TipoIdPersona' => $request->TipoIdPersona,
            'Nombres' => $request->Nombres,
            'Apellidos' => $request->Apellidos,
            'Genero' => $request->Genero,
            'Telefono' => $request->Telefono,
            'Direccion' => $request->Direccion,
            'Correo' => $request->Correo,
            'GrupoSanguineo' => $request->GrupoSanguineo,
            'Titulo' => $request->Titulo,
            'FechaNacimiento' => $request->FechaNacimiento,
            'Foto' => $request->Foto,
            'Estado' => $request->Estado,
        ]);

        if (!$persona) {
            $data = [
                'data' =>  '',
                'message' => 'Error al crear el Persona',
                'exito' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'data' =>  $persona,
            'message' => '',
            'exito' => 201
        ];

        return response()->json($data, 201);
    }
    public function BuscarId($id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            $data = [
                'message' => 'Persona no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'persona' => $persona,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function Eliminar($id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            $data = [
                'message' => 'Persona no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $persona->delete();

        $data = [
            'message' => 'Persona eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function Editar(Request $request, $id)
    {
        $persona = persona::find($id);

        if (!$persona) {
            $data = [
                'message' => 'Persona no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'IdPersona' => 'required',
            'TipoIdPersona' => 'required',
            'Nombres' => 'required',
            'Apellidos' => 'required',
            'Genero' => 'required',
            'Telefono' => 'required',
            'Direccion' => 'required',
            'Correo' => 'required|email',
            'GrupoSanguineo' => 'required',
            'Titulo' => 'required',
            'FechaNacimiento' => 'required',
            'Foto' => 'required',
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

        $persona->IdPersona = $request->IdPersona;
        $persona->TipoIdPersona = $request->TipoIdPersona;
        $persona->Nombres = $request->Nombres;
        $persona->Apellidos = $request->Apellidos;
        $persona->Genero = $request->Genero;
        $persona->Telefono = $request->Telefono;
        $persona->Direccion = $request->Direccion;
        $persona->Correo = $request->Correo;
        $persona->GrupoSanguineo = $request->GrupoSanguineo;
        $persona->Titulo = $request->Titulo;
        $persona->FechaNacimiento = $request->FechaNacimiento;
        $persona->Foto = $request->Foto;
        $persona->Estado = $request->Estado;

        $persona->save();

        $data = [
            'data' =>  $persona,
            'message' => 'Persona actualizado',
            'exito' => 200
        ];

        return response()->json($data, 200);
    }
    public function EditarParcial(Request $request, $id)
    {
        $persona = persona::find($id);

        if (!$persona) {
            $data = [
                'data' =>  '',
                'message' => 'Persona no encontrado',
                'exito' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'IdPersona' => 'max:255',
            'TipoIdPersona' => 'max:255',
            'Nombres' => 'max:255',
            'Apellidos' => 'max:255',
            'Genero' => 'max:255',
            'Telefono' => 'max:255',
            'Direccion' => 'max:255',
            'Correo' => 'max:255|email',
            'GrupoSanguineo' => 'in:O+,A+,A-',
            'Titulo' => 'max:255',
            'FechaNacimiento' => 'max:255',
            'Foto' => 'max:255',
            'Estado' => 'max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('IdPersona')) {
            $persona->IdPersona = $request->IdPersona;
        }

        if ($request->has('TipoIdPersona')) {
            $persona->TipoIdPersona = $request->TipoIdPersona;
        }

        if ($request->has('Nombres')) {
            $persona->Nombres = $request->Nombres;
        }

        if ($request->has('Apellidos')) {
            $persona->Apellidos = $request->Apellidos;
        }
        if ($request->has('Genero')) {
            $persona->Genero = $request->Genero;
        }

        if ($request->has('Telefono')) {
            $persona->Telefono = $request->Telefono;
        }

        if ($request->has('Direccion')) {
            $persona->Direccion = $request->Direccion;
        }

        if ($request->has('Correo')) {
            $persona->Correo = $request->Correo;
        }

        if ($request->has('GrupoSanguineo')) {
            $persona->GrupoSanguineo = $request->GrupoSanguineo;
        }

        if ($request->has('Titulo')) {
            $persona->Titulo = $request->Titulo;
        }
        if ($request->has('FechaNacimiento')) {
            $persona->FechaNacimiento = $request->FechaNacimiento;
        }
        if ($request->has('Foto')) {
            $persona->Foto = $request->Foto;
        }
        if ($request->has('Estado')) {
            $persona->Estado = $request->Estado;
        }

        $persona->save();

        $data = [
            'message' => 'Persona actualizado',
            'persona' => $persona,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
