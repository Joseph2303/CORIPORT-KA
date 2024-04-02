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
        // Recuperar todas las justificaciones de ausencia
        $data = JustificacionAusencia::all();
    
        // Verificar si se encontraron datos
        if ($data->isEmpty()) {
            $response = [
                "status" => 404,
                "message" => "No se encontraron justificaciones de ausencia",
                "data" => [],
            ];
        } else {
            // Cargar relaciones relacionadas con los registros de ausencia,
            // empleados, usuarios y puestos
            $data->load('registroAusencia', 'registroAusencia.empleado', 'registroAusencia.empleado.usuario', 'registroAusencia.empleado.puesto');
    
            // Preparar la respuesta
            $response = [
                "status" => 200,
                "message" => "Consulta generada exitosamente",
                "data" => $data,
            ];
        }
    
        // Devolver la respuesta en formato JSON
        return response()->json($response);
    }
    

    public function show($id)
    {
        $justificacionAusencia = JustificacionAusencia::find($id);
        if (is_object($justificacionAusencia)) {
            $response = [
                'status' => 200,
                'message' => 'Consulta generada exitosamente',
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
        try {
            $dataInput = $request->input('data', null);
            $data = json_decode($dataInput, true);
    
            if (!empty($data)) {
                $data = array_map('trim', $data);
                $rules = [
                    'fechaSolicitud' => 'required|date',
                    'fechaAusencia' => 'required|date',
                    'archivo' => 'required',
                    'justificacion' => 'required',
                    'estado' => 'required',
                    'descripcion' => 'required',
                    'encargado' => 'required|required|regex:/^[a-zA-Z\s]+$/',
                    'idEmpleado' => 'required|integer'
                ];
    
                $valid = \validator($data, $rules);
    
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
            } else {
                $response = [
                    'status' => 406,
                    'message' => 'Datos requeridos',
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Error al guardar los datos',
                'error' => $e->getMessage(),
            ];
        }
    
        return response()->json($response, $response['status']);
    }
    

    public function update(Request $request, $id)
{
    try {
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);

        if (empty($data)) {
            $response = [
                'status' => 400,
                'message' => 'Datos no proporcionados o incorrectos',
            ];
        } else {
            $data = array_map('trim', $data);

            $rules = [
                'fechaSolicitud' => 'required|date',
                'fechaAusencia' => 'required|date',
                'archivo' => 'required',
                'justificacion' => 'required',
                'estado' => 'required',
                'descripcion' => 'required',
                'encargado' => 'required',
                'idEmpleado' => 'required|integer',
            ];

            $valid = \validator($data, $rules);

            if ($valid->fails()) {
                $response = [
                    'status' => 406,
                    'message' => 'Datos enviados no cumplen con las reglas establecidas',
                    'errors' => $valid->errors(),
                ];
            } else {
                if (!empty($id)) {
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
                } else {
                    $response = [
                        'status' => 400,
                        'message' => 'El ID de la justificación de ausencia no es válido',
                    ];
                }
            }
        }
    } catch (\Exception $e) {
        $response = [
            'status' => 500,
            'message' => 'Error al actualizar los datos',
            'error' => $e->getMessage(),
        ];
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
