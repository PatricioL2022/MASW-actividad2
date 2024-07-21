<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Usuario' => 'required',
            'Password' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'mensaje' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data);
        }

        $usuario = Usuario::join('rol', 'usuario.rol_id', '=', 'rol.id')
            ->join('persona', 'usuario.persona_id', '=', 'persona.id')
            ->where('Usuario', $request->Usuario)
            ->where('Password', $request->Password)
            ->select(
                'usuario.Usuario',
                'usuario.rol_id',
                'persona.Nombres',
                'persona.Apellidos',
                'rol.descripcion',
                'rol.Estado as rol_estado',
                'usuario.Estado',
            )
            ->first();


        if (!$usuario) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Usuario o clave erroneos',
                'exito' => 500
            ];
            return response()->json($data);
        }
        if ($usuario->Estado != 'Activo') {
            $data = [
                'data' =>  '',
                'mensaje' => 'Usuario Inactivo',
                'exito' => 500
            ];
            return response()->json($data);
        }
        if ($usuario->rol_estado != 'Activo') {
            $data = [
                'data' =>  '',
                'mensaje' => 'Rol Inactivo',
                'exito' => 500
            ];
            return response()->json($data);
        }

        $user = [
            'Usuario' => $usuario->Usuario,
            'Nombres' => $usuario->Nombres,
            'Apellidos' => $usuario->Apellidos,
            'descripcion' => $usuario->descripcion,
        ];
        $data = [
            'data' =>  $user,
            'mensaje' => '',
            'exito' => 201
        ];

        return response()->json($data);
    }
}
