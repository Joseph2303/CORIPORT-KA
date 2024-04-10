<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JustificacionTardia;

class JustificacionTardiaController extends Controller
{
    public function __construct(){
        $this->middleware('api.auth', ['except' => ['index','show', 'store', 'delete','update']]);
    }

    public function index()
    {
        // Recuperar todas las justificaciones de Tardia
        $data = JustificacionTardia::all();
    
        // Verificar si se encontraron datos
        if ($data->isEmpty()) {
            $response = [
                "status" => 404,
                "message" => "No se encontraron justificaciones de Tardia",
                "data" => [],
            ];
        } else {
            // Cargar relaciones relacionadas con los registros de Tardia,
            // empleados, usuarios y puestos
            $data->load('registroTardia', 'registroTardia.empleado', 'registroTardia.empleado.usuario', 'registroTardia.empleado.puesto');
    
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
        $justificacionTardia = JustificacionTardia::find($id);
        if (is_object($justificacionTardia)) {
            $response = [
                'status' => 200,
                'message' => 'Consulta generada exitosamente',
                'data' => $justificacionTardia,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Justificación de Tardia no encontrada',
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
                    'fechaTardia' => 'required|date',
                   // 'archivo' => 'required',
                    'justificacion' => 'required',
                    'estado' => 'required',
                    'descripcion' => 'required',
                    'encargado' => 'required|required|regex:/^[a-zA-Z\s]+$/',
                ];
    
                $valid = \validator($data, $rules);
    
                if (!$valid->fails()) {
                    date_default_timezone_set('America/Costa_Rica');

                    $justificacionTardia =  new JustificacionTardia();
                    $justificacionTardia->fechaSolicitud = date('Y-m-d');;
                    $justificacionTardia->fechaTardia =  $data['fechaTardia'];
                   // $justificacionTardia->archivo =  $data['archivo'];
                    $justificacionTardia->justificacion = $data['justificacion'];
                    $justificacionTardia->estado = $data['estado'];
                    $justificacionTardia->descripcion = $data['descripcion'];
                    $justificacionTardia->encargado = $data['encargado'];
                    $justificacionTardia->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Datos guardados exitosamente',
                        'data' => $justificacionTardia,
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
                'fechaTardia' => 'required|date',
                //'archivo' => 'required',
                'justificacion' => 'required',
                'estado' => 'required',
                'descripcion' => 'required',
                'encargado' => 'required',
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
                    $justificacionTardia = JustificacionTardia::find($id);

                    if ($justificacionTardia) {
                        $justificacionTardia->update($data);

                        $response = [
                            'status' => 200,
                            'message' => 'Datos actualizados satisfactoriamente',
                            'data' => $justificacionTardia,
                        ];
                    } else {
                        $response = [
                            'status' => 400,
                            'message' => 'No se pudo actualizar la justificación de Tardia, puede ser que no exista',
                        ];
                    }
                } else {
                    $response = [
                        'status' => 400,
                        'message' => 'El ID de la justificación de Tardia no es válido',
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
        $justificacionTardia = JustificacionTardia::find($id);

        if ($justificacionTardia) {
            $justificacionTardia->delete();

            $response = [
                'status' => 200,
                'message' => 'Justificación de Tardia eliminada correctamente',
            ];
        } else {
            $response = [
                'status' => 400,
                'message' => 'No se pudo eliminar la justificación de Tardia, puede ser que no exista',
            ];
        }

        return response()->json($response, $response['status']);
    }
}
