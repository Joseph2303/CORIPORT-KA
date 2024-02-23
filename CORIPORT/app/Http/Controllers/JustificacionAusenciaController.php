<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JustificacionAusencia;

class JustificacionAusenciaController extends Controller
{
    public function __construct(){
        $this->middleware('api.auth', ['except' => ['index','show', 'store', 'delete','update']]);
    }

    public function index()
    {
        $data = JustificacionAusencia::all();
        
        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $justificacionAusencia = JustificacionAusencia::find($id);
        if (is_object($justificacionAusencia)) {
            $response = [
                'status' => 200,
                'data' => $justificacionAusencia,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Justificación de Ausencia no encontrada',
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'fechaSolicitud' => 'required|date',
            'fechaAusencia' => 'required|date',
            'archivos' => 'required',
            'justificacion' => 'required',
            'estado' => 'required',
            'descripcion' => 'required',
            'NombreEncargado' => 'required',
            'idEmpleado' => 'required|integer',
        ];

        $valid = validator($data, $rules);

        if (!$valid->fails()) {
            $justificacionAusencia = JustificacionAusencia::create($data);

            $response = [
                'status' => 200,
                'message' => 'Datos guardados exitosamente',
                'data' => $justificacionAusencia,
            ];
        } else {
            $response = [
                'status' => 406,
                'message' => 'Error en la validación de los datos',
                'errors' => $valid->errors(),
            ];
        }

        return response()->json($response, $response['status']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $rules = [
            'fechaSolicitud' => 'required|date',
            'fechaAusencia' => 'required|date',
            'archivos' => 'required', 
            'justificacion' => 'required',
            'estado' => 'required',
            'descripcion' => 'required',
            'NombreEncargado' => 'required',
            'idEmpleado' => 'required|integer',
        ];

        $valid = validator($data, $rules);

        if ($valid->fails()) {
            $response = [
                'status' => 406,
                'message' => 'Datos enviados no cumplen con las reglas establecidas',
                'errors' => $valid->errors(),
            ];
        } else {
            $justificacionAusencia = JustificacionAusencia::find($id);

            if ($justificacionAusencia) {
                $justificacionAusencia->update($data);
                
                $response = [
                    'status' => 200,
                    'message' => 'Datos actualizados satisfactoriamente',
                    'data' => $justificacionAusencia,
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'No se pudo actualizar la justificación de ausencia, puede ser que no exista',
                ];
            }
        }

        return response()->json($response, $response['status']);
    }

    public function delete($id)
    {
        $justificacionAusencia = JustificacionAusencia::find($id);

        if ($justificacionAusencia) {
            $justificacionAusencia->delete();

            $response = [
                'status' => 200,
                'message' => 'Justificación de Ausencia eliminada correctamente',
            ];
        } else {
            $response = [
                'status' => 400,
                'message' => 'No se pudo eliminar la justificación de ausencia, puede ser que no exista',
            ];
        }

        return response()->json($response, $response['status']);
    }
}
