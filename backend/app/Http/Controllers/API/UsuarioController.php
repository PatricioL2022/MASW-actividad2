<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsuarioController
{
    public function ListarUsuarios()
    {
        $Usuarios = Usuario::all();
        $data = [
            'data' => $Usuarios,
            'message' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data, 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'Usuario' => 'required|string|max:255',
            'Clave' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = Usuario::where('Usuario', $request->Usuario)->first();
        if ($user) {
            if (Hash::check($request->Clave, $user->Clave)) {
                //$token = $user->createToken('Laravel Password Grant Client')->accessToken;
                //$response = ['token' => $token];
                $data = [
                    'data' => $user,
                    'message' => 'Exito',
                    'exito' => 200
                ];
                return response()->json($data, 200);
            } else {
                $response = ["message" => "Contraseña no coincide"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'El usuario no existe'];
            return response($response, 422);
        }
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Usuario' => 'required',
            'Clave' => 'required',
            'confirmar_clave' => 'required|same:Clave',
            'persona_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            $data = [
                'data' =>  $validator->errors(),
                'message' => 'Error en la validación de los datos',
                'exito' => 400
            ];
            return response()->json($data, 400);
        }
   
        $input = $request->all();
        $input['Clave'] = bcrypt($input['Clave']);
        $input['Estado'] = 'Activo';
        $input['FechaIn'] = date("Y-m-d");
        $user = Usuario::create($input);
        //$success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        //$success['name'] =  $user->name;
   
        if (!$user) {
            $data = [
                'data' =>  '',
                'message' => 'Error al crear el usuario.',
                'exito' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'data' =>  $user,
            'message' => '',
            'exito' => 201
        ];

        return response()->json($data, 201);
    }
}
