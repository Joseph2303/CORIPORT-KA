<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puesto;

class PuestoController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show', 'store', 'update', 'delete']]);
    }

    public function index()
    {
        $data = Puesto::all();
        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $puesto = Puesto::find($id);
        if (is_object($puesto)) {
            $response = [
                'status' => 200,
                'data' => $puesto,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Puesto no encontrado',
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
                    'puesto' => 'required',                
                ];
                $valid = \validator($data, $rules);

                if (!$valid->fails()) {
                    $puestos= new Puesto();
                    $puestos->puesto = $data['puesto'];
                   
                    $puestos->save();
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
                        'puesto' => 'required',
                        
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
                            $puestos = Puesto::find($id);
        
                            if ($puestos) {
                                $puestos->update($data);
        
                                $response = array(
                                    'status' => 200,
                                    'message' => 'Datos actualizados satisfactoriamente',
                                );
                            } else {
                                $response = array(
                                    'status' => 400,
                                    'message' => 'El puesto no existe',
                                );
                            }
                        } else {
                            $response = array(
                                'status' => 400,
                                'message' => 'El ID del puesto no es válido',
                            );
                        }
                    }
                }
        
                return response()->json($response, $response['status']);
        }
    }
    public function delete($id)
    {
        $puesto = Puesto::find($id);
        if ($puesto) {
            $puesto->delete();
            $response = [
                'status' => 200,
                'message' => 'Puesto eliminado correctamente',
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'No se pudo eliminar el puesto, puede ser que no exista',
            ];
        }

        return response()->json($response, $response['status']);
    }
}
