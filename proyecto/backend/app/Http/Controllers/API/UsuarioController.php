<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $q = Usuario::join('persona', 'usuario.persona_id', '=', 'persona.id')
            ->join('rol', 'usuario.rol_id', '=', 'rol.id')
            ->where('usuario.Estado', 'Activo')
            ->select(
                'usuario.id',
                'usuario.Usuario',
                'usuario.Password',
                'persona.Identificacion',
                'persona.Nombres',
                'persona.Apellidos',
                'persona.Genero',
                'persona.Telefono',
                'persona.Correo',
                'persona.FechaNacimiento',
                'rol.Descripcion',
                'usuario.rol_id',
                'usuario.persona_id',
                'usuario.Estado',
            )
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
        $query = usuario::query();

        switch ($tipo) {

            case 0:
                $query->join('persona', 'usuario.persona_id', '=', 'persona.id')
                    ->join('rol', 'usuario.rol_id', '=', 'rol.id')
                    ->where('usuario.Estado', $valor);
                break;
            case 1:
                $query->join('persona', 'usuario.persona_id', '=', 'persona.id')
                    ->join('rol', 'usuario.rol_id', '=', 'rol.id')
                    ->where('usuario.Usuario', strtoupper($valor));
                break;

            case 2:
                $query->join('persona', 'usuario.persona_id', '=', 'persona.id')
                    ->join('rol', 'usuario.rol_id', '=', 'rol.id')
                    ->where('persona.Nombres', 'like', '%' . strtoupper($valor) . '%');
                break;

            default:

                return response()->json([
                    'data' => [],
                    'exito' => 400,
                    'mensaje' => 'Tipo no válido'
                ]);
        }

        $result = $query->select(
            'usuario.id',
            'usuario.Usuario',
            'usuario.Password',
            'persona.Identificacion',
            'persona.Nombres',
            'persona.Apellidos',
            'persona.Genero',
            'persona.Telefono',
            'persona.Correo',
            'persona.FechaNacimiento',
            'rol.Descripcion',
            'usuario.rol_id',
            'usuario.persona_id',
            'usuario.Estado',
        )
            ->orderBy('usuario.id', 'desc')->take(100)->get();

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
        'Usuario' => 'required|string|max:10|unique:usuarios,Usuario', // Verifica que el nombre de la tabla es correcto
        'Password' => 'required|string|max:20',
        'rol_id' => 'required|integer',
        'persona_id' => 'required|integer',
        'Estado' => 'required|in:Activo,Inactivo',
    ]);

    if ($validator->fails()) {
        $data = [
            'data' => $validator->errors(),
            'mensaje' => 'Error en la validación de los datos',
            'exito' => 400
        ];
        return response()->json($data, 400);
    }

    // $hashedPassword = Hash::make($request->Password);

    try {
        $Usuario = Usuario::create([
            'Usuario' => $request->Usuario,
            'Password' => $request->Password,
            'rol_id' => $request->rol_id,
            'persona_id' => $request->persona_id,
            'Estado' => $request->Estado,
        ]);

        $data = [
            'data' => $Usuario,
            'mensaje' => 'Usuario creado con éxito',
            'exito' => 201
        ];
        return response()->json($data, 201);
    } catch (\Exception $e) {
        // Manejar cualquier error que ocurra durante la creación del usuario
        $data = [
            'data' => '',
            'mensaje' => 'Error al crear el Usuario: ' . $e->getMessage(),
            'exito' => 500
        ];
        return response()->json($data, 500);
    }
}


    public function Editar(Request $request)
    {
        $UsuarioReq = Usuario::find($request->id);

        if (!$UsuarioReq) {
            $data = [
                'mensaje' => 'Usuario no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }
        $validator = Validator::make($request->all(), [
            'Usuario' => 'required|string',
            'Password' => 'required|string',
            'rol_id' => 'required',
            'persona_id' => 'required',
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
        // $hashedPassword = Hash::make($request->Password);

        $UsuarioReq->Usuario = $request->Usuario;
        $UsuarioReq->Password = $request->Password;
        $UsuarioReq->rol_id = $request->rol_id;
        $UsuarioReq->persona_id = $request->persona_id;
        $UsuarioReq->Estado = $request->Estado;

        $UsuarioReq->save();

        $data = [
            'data' =>  $UsuarioReq,
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
            'persona_id' => 'number',
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
        if ($request->has('persona_id')) {
            $Usuario->persona_id = $request->persona_id;
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
