<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController
{
    public function ListarUsuarios()
    {
        $Usuarios = Usuario::all();
        $data = [
            'data' => $Usuarios,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data);
    }
    public function ListarUsuariosPag($codigo, $rango)
    {
        $q = Usuario::where('Estado', 'Activo')
            ->orderBy('id', 'desc')
            ->skip($codigo)
            ->take($rango == 0 ? 1000 : $rango)
            ->get();
        $data = [
            'data' => $q,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data);
    }
    public function Filtrar($tipo, $valor)
    {
        $query = Usuario::query();

        if ($tipo == 0) {
            $query->where('Estado', $valor);
        } elseif ($tipo == 1) {
            $query->where('Identificacion', strtoupper($valor));
        } elseif ($tipo == 2) {
            $query->where('Nombres', strtoupper($valor));
        } elseif ($tipo == 3) {
            $query->where('Nombres', 'like', '%' . strtoupper($valor) . '%');
        } elseif ($tipo == 4) {
            $query->where('Apellidos', strtoupper($valor));
        } elseif ($tipo == 5) {
            $query->where('Apellidos', 'like', '%' . strtoupper($valor) . '%');
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
        $Usuario = Usuario::find($id);

        if (!$Usuario) {
            $data = [
                'mensaje' => 'Usuario no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $data = [
            'Usuario' => $Usuario,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Usuario' => 'required|string|max:10|unique:usuario,Usuario',
            'Password' => 'required|string|max:20',
            'rol_id' => 'required|number',
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

        $Usuario = Usuario::create([
            'Usuario' => $request->Usuario,
            'Password' => $request->Password,
            'rol_id' => $request->rol_id,
            'Estado' => $request->Estado,
        ]);

        if (!$Usuario) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Error al crear el Usuario',
                'exito' => 500
            ];
            return response()->json($data);
        }

        $data = [
            'data' =>  $Usuario,
            'mensaje' => '',
            'exito' => 201
        ];

        return response()->json($data);
    }
    public function Editar(Request $request)
    {
        $Usuario = Usuario::find($request->id);

        if (!$Usuario) {
            $data = [
                'mensaje' => 'Usuario no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Usuario' => 'required|string|max:10|unique:Usuario',
            'Password' => 'required|string|max:20',
            'rol_id' => 'required|number',
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

        $Usuario->Usuario = $request->Usuario;
        $Usuario->Password = $request->Password;
        $Usuario->rol_id = $request->rol_id;
        $Usuario->Estado = $request->Estado;

        $Usuario->save();

        $data = [
            'data' =>  $Usuario,
            'mensaje' => 'Usuario actualizado',
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function EditarParcial(Request $request)
    {
        $Usuario = Usuario::find($request->id);

        if (!$Usuario) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Usuario no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Usuario' => 'string|max:10|unique:usuario,Usuario',
            'Password' => 'string|max:20',
            'rol_id' => 'number',
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

        if ($request->has('Usuario')) {
            $Usuario->Usuario = $request->Usuario;
        }
        if ($request->has('Password')) {
            $Usuario->Password = $request->Password;
        }
        if ($request->has('rol_id')) {
            $Usuario->rol_id = $request->rol_id;
        }
        $Usuario->save();

        $data = [
            'mensaje' => 'Usuario actualizada',
            'Usuario' => $Usuario,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function Eliminar($id)
    {
        $Usuario = Usuario::find($id);

        if (!$Usuario) {
            $data = [
                'mensaje' => 'Usuario no encontrada',
                'exito' => 404
            ];
            return response()->json($data);
        }

        try {
            $Usuario->delete();
            $data = [
                'mensaje' => 'Usuario eliminada',
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
                    'mensaje' => 'Error al eliminar la Usuario: ' . $e->getMessage(),
                    'exito' => 500
                ];
            }
        }

        return response()->json($data);
    }


}
