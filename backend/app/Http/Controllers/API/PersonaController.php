<?php

namespace App\Http\Controllers\API;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaController
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
        // $validator = Validator::make($request->all(), [
        //     'TipoIdentificacion' => 'requiered',
        //     'Identificacion' => 'requiered',
        //     'Nombres' => 'requiered',
        //     'Apellidos' => 'requiered',
        //     'Genero' => 'requiered',
        //     'GrupoSanguineo' => 'requiered',
        //     'Direccion' => 'requiered',
        //     'Telefono' => 'requiered',
        //     'Correo' => 'requiered|email',
        //     'Titulo' => 'requiered',
        //     'FechaNacimiento' => 'requiered',
        //     'Foto' => 'requiered',
        //     'Estado' => 'requiered'
        // ]);

        // if ($validator->fails()) {
        //     $data = [
        //         'data' =>  $validator->errors(),
        //         'message' => 'Error en la validación de los datos',
        //         'exito' => 400
        //     ];
        //     return response()->json($data, 400);
        // }

        $persona = Persona::create([
            'Identificacion' => $request->Identificacion,
            'Nombres' => $request->Nombres,
            'Apellidos' => $request->Apellidos,
            'TipoIdentificacion' => $request->TipoIdentificacion,
            'Genero' => $request->Genero,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'Correo' => $request->Correo,
            'Titulo' => $request->Titulo,
            'FechaNacimiento' => $request->FechaNacimiento,
            'Foto' => $request->Foto,
            'GrupoSanguineo' => $request->GrupoSanguineo,
            'Estado' => $request->Estado,
        ]);

        if (!$persona) {
            $data = [
                'data' =>  '',
                'message' => 'Error al crear el persona',
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
            'TipoIdentificacion' => 'requiered',
            'Identificacion' => 'requiered',
            'Nombres' => 'requiered',
            'Apellidos' => 'requiered',
            'Genero' => 'requiered',
            'GrupoSanguineo' => 'requiered',
            'Direccion' => 'requiered',
            'Telefono' => 'requiered',
            'Correo' => 'requiered|email',
            'Titulo' => 'requiered',
            'FechaNacimiento' => 'requiered',
            'Foto' => 'requiered',
            'Estado' => 'requiered',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
        }

        $persona->Identificacion = $request->Identificacion;
        $persona->Nombres = $request->Nombres;
        $persona->Apellidos = $request->Apellidos;
        $persona->TipoIdentificacion = $request->TipoIdentificacion;
        $persona->Genero = $request->Genero;
        $persona->Direccion = $request->Direccion;
        $persona->Telefono = $request->Telefono;
        $persona->Correo = $request->Correo;
        $persona->Titulo = $request->Titulo;
        $persona->FechaNacimiento = $request->FechaNacimiento;
        $persona->Foto = $request->Foto;
        $persona->GrupoSanguineo = $request->GrupoSanguineo;
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
            'TipoIdentificacion' => 'max150',
            'Identificacion' => 'max150',
            'Nombres' => 'max150',
            'Apellidos' => 'max150',
            'Genero' => 'max150',
            'GrupoSanguineo' => 'max150',
            'Direccion' => 'max150',
            'Telefono' => 'max150',
            'Correo' => 'max150',
            'Titulo' => 'max150',
            'FechaNacimiento' => 'max150',
            'Foto' => 'max150',
            'Estado' => 'max150',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('Identificacion')) {
            $persona->Identificacion = $request->Identificacion;
        }
        if ($request->has('Nombres')) {
            $persona->Nombres = $request->Nombres;
        }
        if ($request->has('Apellidos')) {
            $persona->Apellidos = $request->Apellidos;
        }
        if ($request->has('TipoIdentificacion')) {
            $persona->TipoIdentificacion = $request->TipoIdentificacion;
        }
        if ($request->has('Genero')) {
            $persona->Genero = $request->Genero;
        }
        if ($request->has('Direccion')) {
            $persona->Direccion = $request->Direccion;
        }
        if ($request->has('Telefono')) {
            $persona->Telefono = $request->Telefono;
        }
        if ($request->has('Correo')) {
            $persona->Correo = $request->Correo;
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
        if ($request->has('GrupoSanguineo')) {
            $persona->GrupoSanguineo = $request->GrupoSanguineo;
        }
        if ($request->has('Estado')) {
            $persona->Estado = $request->Estado;
        }

        $persona->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'persona' => $persona,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
