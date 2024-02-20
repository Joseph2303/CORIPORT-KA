<?php

namespace App\Http\Controllers;

use App\Models\DiasFeriados;
use Illuminate\Http\Request;

class DiasFeriadosController extends Controller
{

    public function __construct(){
        $this->middleware('api.auth', ['except' => ['index','show', 'store', 'delete','update']]);
    }

    public function __invoke()
    {
    }

    public function index()
    {
        $data = DiasFeriados::all();
        if ($data) {
            $response = array(
                "status" => 200,
                "message" => "Consulta generada exitosamente",
                "data" => $data
            );
        }
        return response()->json($response, 200);
    }


    public function store(Request $request)
    {
        try {
            $dataInput = $request->input('data', null);
            $data = json_decode($dataInput, true);
            
            if (!empty($data)) {
                $data = array_map('trim', $data);
                $rules = [
                    'fecha' => 'required|date',
                    'descripcion' => 'required',
                    'tipoFeriado' => 'required'
                ];
                $valid = \validator($data, $rules);
    
                if (!$valid->fails()) {
                    $diasFeriados = new DiasFeriados();
                    $diasFeriados->fecha = $data['fecha'];
                    $diasFeriados->descripcion = $data['descripcion'];
                    $diasFeriados->tipoFeriado = $data['tipoFeriado'];
                    $diasFeriados->save();
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
            // En caso de que ocurra una excepción al guardar
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
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);
    
        if (empty($data)) {
            $response = array(
                'status' => 400,
                'message' => 'Datos no proporcionados o incorrectos',
            );
        } else {
            $rules = [
                'fecha' => 'required|date',
                'descripcion' => 'required',
                'tipoFeriado' => 'required'
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
                    $diasFeriados = DiasFeriados::find($id);
    
                    if ($diasFeriados) {
                        $diasFeriados->update($data);
    
                        $response = array(
                            'status' => 200,
                            'message' => 'Datos actualizados satisfactoriamente',
                        );
                    } else {
                        $response = array(
                            'status' => 400,
                            'message' => 'El dia feriado no existe',
                        );
                    }
                } else {
                    $response = array(
                        'status' => 400,
                        'message' => 'El ID del dia feriado no es válido',
                    );
                }
            }
        }
    
        return response()->json($response, $response['status']);
    }
    


    public function delete($id)
    {
        if (isset($id)) {
            $deleted = DiasFeriados::where('id', $id)->delete();
            if ($deleted) {
                $response = array(
                    'status' => 200,
                    'message' => 'Dia feriado eliminado correctamente'
                );
            } else {
                $response = array(
                    'status' => 400,
                    'message' => 'No se pudo eliminar el recurso'
                );
            }
        } else {
            $response = array(
                'status' => 400,
                'message' => 'Falta el identificador(id) del recurso a eliminar'
            );
        }
        return response()->json($response, $response['status']);
    }

    public function show($id)
    {
        $diaFeriado = DiasFeriados::find($id);
        if (is_object($diaFeriado)) {
            $response = [
                'status' => 200,
                'data' => $diaFeriado,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Dia feriado no encontrado',
            ];
        }
        return response()->json($response, $response['status']);
    }

}
