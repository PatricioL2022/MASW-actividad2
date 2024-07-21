<?php

namespace App\Http\Controllers\API;

use App\Models\Consultorio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultorioController extends Controller
{
    public function ListarConsultorios()
    {
        $Consultorios = Consultorio::all();
        $data = [
            'data' => $Consultorios,
            'mensaje' => 'Exito',
            'exito' => 200
        ];
        return response()->json($data);
    }
    public function ListarConsultoriosPag($codigo, $rango)
    {
        $q = Consultorio::where('Estado', 'Activo')
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
        $query = Consultorio::query();

        if ($tipo == 0) {
            $query->where('Estado', $valor);
        } elseif ($tipo == 1) {
            $query->where('Ruc', strtoupper($valor));
        } elseif ($tipo == 2) {
            $query->where('Nombre', strtoupper($valor));
        } elseif ($tipo == 3) {
            $query->where('Nombre', 'like', '%' . strtoupper($valor) . '%');
        } elseif ($tipo == 4) {
            $query->where('NombreComercial', strtoupper($valor));
        } elseif ($tipo == 5) {
            $query->where('NombreComercial', 'like', '%' . strtoupper($valor) . '%');
        } elseif ($tipo == 6) {
            $query->where('Ruc', strtoupper($valor))
                ->orWhere('Nombre', 'like', '%' . strtoupper($valor) . '%');
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
        $Consultorio = Consultorio::find($id);

        if (!$Consultorio) {
            $data = [
                'mensaje' => 'Consultorio no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $data = [
            'Consultorio' => $Consultorio,
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function Agregar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|max:120',
            'Ruc' => 'required|max:13',
            'NombreComercial' => 'required|max:120',
            'Direccion' => 'required|max:250',
            'Telefono' => 'required|max:10',
            'PorcentajeIva' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'Logo' => 'required',
            'Correo' => 'required|email|max:50',
            'DireccionMatriz' => 'required|max:250',
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

        $Consultorio = Consultorio::create([
            'Nombre' => $request->Nombre,
            'Ruc' => $request->Ruc,
            'NombreComercial' => $request->NombreComercial,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'PorcentajeIva' => $request->PorcentajeIva,
            'Logo' => $request->Logo,
            'Correo' => $request->Correo,
            'DireccionMatriz' => $request->DireccionMatriz,
            'Estado' => $request->Estado,
        ]);

        if (!$Consultorio) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Error al crear el estudiante',
                'exito' => 500
            ];
            return response()->json($data);
        }

        $data = [
            'data' =>  $Consultorio,
            'mensaje' => '',
            'exito' => 201
        ];

        return response()->json($data);
    }
    public function Editar(Request $request)
    {
        $Consultorio = Consultorio::find($request->id);

        if (!$Consultorio) {
            $data = [
                'mensaje' => 'Consultorio no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|max:120',
            'Ruc' => 'required|max:13',
            'NombreComercial' => 'required|max:120',
            'Direccion' => 'required|max:250',
            'Telefono' => 'required|max:10',
            'PorcentajeIva' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'Logo' => 'required',
            'Correo' => 'required|email|max:50',
            'DireccionMatriz' => 'required|max:250',
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

        $Consultorio->Nombre = $request->Nombre;
        $Consultorio->Ruc = $request->Ruc;
        $Consultorio->NombreComercial = $request->NombreComercial;
        $Consultorio->Direccion = $request->Direccion;
        $Consultorio->Telefono = $request->Telefono;
        $Consultorio->PorcentajeIva = $request->PorcentajeIva;
        $Consultorio->Logo = $request->Logo;
        $Consultorio->Correo = $request->Correo;
        $Consultorio->DireccionMatriz = $request->DireccionMatriz;
        $Consultorio->Estado = $request->Estado;

        $Consultorio->save();

        $data = [
            'data' =>  $Consultorio,
            'mensaje' => 'Consultorio actualizado',
            'exito' => 200
        ];

        return response()->json($data);
    }
    public function EditarParcial(Request $request)
    {
        $Consultorio = Consultorio::find($request->id);

        if (!$Consultorio) {
            $data = [
                'data' =>  '',
                'mensaje' => 'Consultorio no encontrado',
                'exito' => 404
            ];
            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'Nombre' => 'max:120',
            'Ruc' => 'max:13',
            'NombreComercial' => 'max:120',
            'Direccion' => 'max:250',
            'Telefono' => 'max:10',
            'PorcentajeIva' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'Logo' => '',
            'Correo' => 'email|max:50',
            'DireccionMatriz' => 'max:250',
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

        if ($request->has('Nombre')) {
            $Consultorio->Nombre = $request->Nombre;
        }

        if ($request->has('Ruc')) {
            $Consultorio->Ruc = $request->Ruc;
        }

        if ($request->has('NombreComercial')) {
            $Consultorio->NombreComercial = $request->NombreComercial;
        }

        if ($request->has('Direccion')) {
            $Consultorio->Direccion = $request->Direccion;
        }
        if ($request->has('Telefono')) {
            $Consultorio->Telefono = $request->Telefono;
        }

        if ($request->has('PorcentajeIva')) {
            $Consultorio->PorcentajeIva = $request->PorcentajeIva;
        }

        if ($request->has('Logo')) {
            $Consultorio->Logo = $request->Logo;
        }

        if ($request->has('Correo')) {
            $Consultorio->Correo = $request->Correo;
        }

        if ($request->has('DireccionMatriz')) {
            $Consultorio->DireccionMatriz = $request->DireccionMatriz;
        }
        if ($request->has('Estado')) {
            $Consultorio->Estado = $request->Estado;
        }

        $Consultorio->save();

        $data = [
            'mensaje' => 'Estudiante actualizado',
            'Consultorio' => $Consultorio,
            'exito' => 200
        ];

        return response()->json($data);
    }

    public function Eliminar($id)
    {

        $Consultorio = Consultorio::find($id);

        if (!$Consultorio) {
            $data = [
                'mensaje' => 'Consultorio no encontrada',
                'exito' => 404
            ];
            return response()->json($data);
        }

        try {
            $Consultorio->delete();
            $data = [
                'mensaje' => 'Consultorio eliminada',
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
                    'mensaje' => 'Error al eliminar la Consultorio: ' . $e->getMessage(),
                    'exito' => 500
                ];
            }
        }

        return response()->json($data);
    }
}
