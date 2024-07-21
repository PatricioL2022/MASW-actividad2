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
    public function ListarPersonasPag($codigo, $rango)
    {
        $q = Persona::where('Estado', 'Activo')
            ->orderBy('id', 'desc')
            ->skip($codigo)
            ->take($rango == 0 ? 1000 : $rango)
            ->get();
        $data = [
            'data' => $q,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }
    public function Filtrar($tipo, $valor)
    {
        $query = Persona::query();

        if ($tipo == 0) {
            $query->where('Estado', $valor);
        } elseif ($tipo == 1) {
            $query->where('Identificacion', strtoupper($valor))
                ->where('Estado', 'Activo');
        } elseif ($tipo == 2) {
            $query->where('Nombres', strtoupper($valor))
                ->where('Estado', 'Activo');
        } elseif ($tipo == 3) {
            $query->where('Nombres', 'like', '%' . strtoupper($valor) . '%')
                ->where('Estado', 'Activo');
        } elseif ($tipo == 4) {
            $query->where('Apellidos', strtoupper($valor))
                ->where('Estado', 'Activo');
        } elseif ($tipo == 5) {
            $query->where('Apellidos', 'like', '%' . strtoupper($valor) . '%')
                ->where('Estado', 'Activo');
        } else {
            $data = [
                'data' => [],
                'exito' => 400,
                'mensaje' => 'Tipo no válido'
            ];
            return response()->json($data);
        }

        $result = $query->orderBy('id')
            ->take(100)
            ->get();

        $data = [
            'data' => $result,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function BuscarId($id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            $data = [
                'mensaje' => 'Persona no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $data = [
            'persona' => $persona,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Identificacion' => 'required|string|max:13|unique:persona,Identificacion',
            'Nombres' => 'required|string|max:120',
            'Apellidos' => 'required|string|max:120',
            'TipoIdentificacion' => 'required|in:CI,PAS,RUC',
            'Genero' => 'required|in:Masculino,Femenino',
            'Direccion' => 'nullable|string|max:250',
            'Telefono' => 'nullable|string|max:14',
            'Correo' => 'required|string|email|max:150',
            'Titulo' => 'required|string|max:15',
            'FechaNacimiento' => 'required|date',
            'Foto' => 'nullable|string|max:300',
            'GrupoSanguineo' => 'nullable|string|max:4',
            'Estado' => 'required|in:Activo,Inactivo',
        ]);


        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'mensaje' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

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
                'mensaje' => 'Error al crear el persona',
                'exito' => 500
            ];
            return response()->json($data);
        }

        $data = [
            'data' =>  $persona,
            'mensaje' => '',
            'exito' => 201
        ];

        return response()->json($data);
    }
    public function Editar(Request $request)
    {
        $persona = persona::find($request->id);

        if (!$persona) {
            $data = [
                'mensaje' => 'Persona no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Identificacion' => 'required|string|max:13',
            'Nombres' => 'required|string|max:120',
            'Apellidos' => 'required|string|max:120',
            'TipoIdentificacion' => 'required|in:CI,PAS,RUC',
            'Genero' => 'required|in:Masculino,Femenino',
            'Direccion' => 'nullable|string|max:250',
            'Telefono' => 'nullable|string|max:14',
            'Correo' => 'required|string|email|max:150',
            'Titulo' => 'required|string|max:15',
            'FechaNacimiento' => 'required|date',
            'Foto' => 'nullable|string|max:300',
            'GrupoSanguineo' => 'nullable|string|max:4',
            'Estado' => 'required|in:Activo,Inactivo',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'mensaje' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
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
            'mensaje' => 'Persona actualizado',
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function EditarParcial(Request $request)
    {
        $persona = persona::find($request->id);

        if (!$persona) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Persona no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Identificacion' => 'string|max:13',
            'Nombres' => 'string|max:120',
            'Apellidos' => 'string|max:120',
            'TipoIdentificacion' => 'in:CI,PAS,RUC',
            'Genero' => 'in:Masculino,Femenino',
            'Direccion' => 'string|max:250',
            'Telefono' => 'string|max:14',
            'Correo' => 'string|email|max:150',
            'Titulo' => 'string|max:15',
            'FechaNacimiento' => 'date',
            'Foto' => 'string|max:300',
            'GrupoSanguineo' => 'string|max:4',
            'Estado' => 'in:Activo,Inactivo',
        ]);

        if ($validator->fails()) {
            $data = [
                'mensaje' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'exito' => 400
            ];
            return response()->json($data);
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
            'mensaje' => 'Persona actualizada',
            'persona' => $persona,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function Eliminar($id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            $data = [
                'mensaje' => 'Persona no encontrada',
                'exito' => 404
            ];
            return response()->json($data);
        }

        try {
            $persona->delete();
            $data = [
                'mensaje' => 'Persona eliminada',
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
                    'mensaje' => 'Error al eliminar la persona: ' . $e->getMessage(),
                    'exito' => 500
                ];
            }
        }

        return response()->json($data);
    }


}
