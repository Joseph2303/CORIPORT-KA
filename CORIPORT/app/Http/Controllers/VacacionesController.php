<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacaciones;

class VacacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show', 'store', 'update', 'delete']]);
    }

    public function index()
    {
        $data = Vacaciones::all();
        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $vacaciones = Vacaciones::find($id);
        if (is_object($vacaciones)) {
            $response = [
                'status' => 200,
                'data' => $vacaciones,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Vacación no encontrada',
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
                    'periodo' => 'required',
                    'disponibles' => 'required',
                    'diasAsig' => 'required',
                    'idEmpleado' => 'required|integer'
                    
                ];
                $valid = \validator($data, $rules);

                if (!$valid->fails()) {
                    $vacaciones= new Vacaciones();
                    $vacaciones->vacacion = $data['vacaciones'];
                   
                    $vacaciones->save();
                    $response = array(
                        'status' => 200,
                        'message' => 'Datos guardados exitosamente'
                    );
                } else {
                    $response = array(
                        'status' => 406,
                        'message' => 'Error en la validación de los datos',
                        'errors' => $valid->errors(),
                    );
                }
            } else {
                $response = array(
                    'status' => 406,
                    'message' => 'Datos requeridos',
                );
            }
        } catch (\Exception $e) {
            $response = array(
                'status' => 500, // Puedes personalizar el código de estado de error
                'message' => 'Error al guardar los datos',
                'error' => $e->getMessage(), // Agrega información adicional sobre la excepción si es necesario
            );
        }

        return response()->json($response, $response['status']);
    }

    public function update(Request $request, $id)
    {
            {
                $dataInput = $request->input('data', null);
                $data = json_decode($dataInput, true);
        
                if (empty($data)) {
                    $response = array(
                        'status' => 400,
                        'message' => 'Datos no proporcionados o incorrectos',
                    );
                } else {
                    $rules = [
                        'periodo' => 'required',
                        'disponibles' => 'required',
                        'diasAsig' => 'required',
                        'idEmpleado' => 'required|integer'
                        
                    ];
        
                    $valid = \validator($data, $rules);
        
                    if ($valid->fails()) {
                        $response = array(
                            'status' => 406,
                            'message' => 'Datos enviados no cumplen con las reglas establecidas',
                            'errors' => $valid->errors(),
                        );
                    } else {
                        if (!empty($id)) {
                            $vacaciones = Vacaciones::find($id);
        
                            if ($vacaciones) {
                                $vacaciones->update($data);
        
                                $response = array(
                                    'status' => 200,
                                    'message' => 'Datos actualizados satisfactoriamente',
                                );
                            } else {
                                $response = array(
                                    'status' => 400,
                                    'message' => 'Las vacaciones no existen',
                                );
                            }
                        } else {
                            $response = array(
                                'status' => 400,
                                'message' => 'El ID de la vacacion no es válido',
                            );
                        }
                    }
                }
        
                return response()->json($response, $response['status']);
        }
    }
    public function delete($id)
    {
        $vacacion = Vacaciones::find($id);
        if ($vacacion) {
            $vacacion->delete();
            $response = [
                'status' => 200,
                'message' => 'Vacacion eliminado correctamente',
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'No se pudo eliminar la vacacion, puede ser que no exista',
            ];
        }

        return response()->json($response, $response['status']);
    }
}
