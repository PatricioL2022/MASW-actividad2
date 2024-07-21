<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function ListarRol()
    {
        $rols = Rol::all();
        $data = [
            'data' => $rols,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data);
    }
    public function ListarRolPag($codigo, $rango)
    {
        $q = Rol::where('Estado', 'Activo')
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
        $query = Rol::query();

        if ($tipo == 0) {
            $query->where('Estado', $valor);
        } elseif ($tipo == 1) {
            $query->where('Descripcion', strtoupper($valor));
        } elseif ($tipo == 2) {
            $query->where('Descripcion', 'like', '%' . strtoupper($valor) . '%')
            ->where('Estado','Activo');
        }else {
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
        $rol = Rol::find($id);

        if (!$rol) {
            $data = [
                'mensaje' => 'Rol no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $data = [
            'rol' => $rol,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:20',
            'Estado' => 'required|max:13',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'mensaje' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

        $rol = Rol::create([
            'Descripcion' => $request->Descripcion,
            'Estado' => $request->Estado,
        ]);

        if (!$rol) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Error al crear el estudiante',
                'exito' => 500
            ];
            return response()->json($data);
        }

        $data = [
            'data' =>  $rol,
            'mensaje' => '',
            'exito' => 201
        ];

        return response()->json($data);
    }
    public function Editar(Request $request)
    {
        $rol = Rol::find($request->id);

        if (!$rol) {
            $data = [
                'mensaje' => 'rol no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:20',
            'Estado' => 'required|max:13',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'mensaje' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

        $rol->Descripcion = $request->Descripcion;
        $rol->Estado = $request->Estado;

        $rol->save();

        $data = [
            'data' =>  $rol,
            'mensaje' => 'rol actualizado',
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function EditarParcial(Request $request)
    {
        $rol = Rol::find($request->id);

        if (!$rol) {
            $data = [
                'data' =>  '',
                'mensaje' => 'rol no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Descripcion' => 'max:20',
            'Estado' => 'max:13',
        ]);

        if ($validator->fails()) {
            $data = [
                'mensaje' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'exito' => 400
            ];
            return response()->json($data);
        }

        if ($request->has('Descripcion')) {
            $rol->Descripcion = $request->Descripcion;
        }

        if ($request->has('Estado')) {
            $rol->Estado = $request->Estado;
        }

        $rol->save();

        $data = [
            'mensaje' => 'Rol actualizado',
            'rol' => $rol,
            'exito' => 200
        ];

        return response()->json($data);
    }

    public function Eliminar($id)
    {

        $rol = Rol::find($id);

        if (!$rol) {
            $data = [
                'mensaje' => 'rol no encontrada',
                'exito' => 404
            ];
            return response()->json($data);
        }

        try {
            $rol->delete();
            $data = [
                'mensaje' => 'rol eliminada',
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
                    'mensaje' => 'Error al eliminar la rol: ' . $e->getMessage(),
                    'exito' => 500
                ];
            }
        }

        return response()->json($data);
    }
}
