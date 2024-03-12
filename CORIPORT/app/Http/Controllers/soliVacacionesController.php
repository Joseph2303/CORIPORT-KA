<?php

namespace App\Http\Controllers;

use App\Models\solicitudVacaciones;
use Illuminate\Http\Request;

class soliVacacionesController extends Controller
{

    public function __construct(){
        $this->middleware('api.auth', ['except' => ['index','show', 'store', 'delete','update']]);
    }

    public function __invoke()
    {
    }

    public function index()
    {
        $data = solicitudVacaciones::all();
        if ($data) {
            $data = solicitudVacaciones::with('empleado', 'empleado.usuario', 'empleado.puesto')
            ->get();       
        }
        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data,
        ];

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
                    'fechSolicitud' => 'required|alpha',
                    'fechInicio' => 'required|alpha',
                    'fechFin' => 'required|alpha',
                    'estado' => 'required|alpha',
                    'responsableAut' => 'required|alpha',
                    'descripcion'=> 'required|alpha',
                    'idEmpleado'=> 'required|integer'
                ];
                $valid = \validator($data, $rules);
    
                if (!$valid->fails()) {
                    $soliVacaciones = new solicitudVacaciones();
                    $soliVacaciones->fechSolicitud = now();
                    $soliVacaciones->fechInicio = $data['fechInicio'];
                    $soliVacaciones->fechFin = $data['fechFin'];
                    $soliVacaciones->estado = $data['descripcion'];
                    $soliVacaciones->responsableAut = $data['estado'];
                    $soliVacaciones->descripcion = $data['responsableAut'];
                    $soliVacaciones->idEmpleado = $data['idEmpleado'];

                    $soliVacaciones->save();
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
                'fechSolicitud' => 'required|date_format:Y-m-d',
                'fechInicio' => 'required|date_format:Y-m-d',
                'fechFin' => 'required|date_format:Y-m-d',
                'estado' => 'required|alpha',
                'responsableAut' => 'required|alpha',
                'descripcion' => 'required|regex:/^[a-zA-Z\s]+$/',
                'idEmpleado'=> 'required|integer'
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
                    $soliVacaciones = solicitudVacaciones::find($id);
    
                    if ($soliVacaciones) {
                        $soliVacaciones->update($data);
    
                        $response = array(
                            'status' => 200,
                            'message' => 'Datos actualizados satisfactoriamente',
                        );
                    } else {
                        $response = array(
                            'status' => 400,
                            'message' => 'La solicitud no existe',
                        );
                    }
                } else {
                    $response = array(
                        'status' => 400,
                        'message' => 'El ID de la solicitud no es válido',
                    );
                }
            }
        }
    
        return response()->json($response, $response['status']);
    }
    


    public function delete($id)
    {
        if (isset($id)) {
            $deleted = solicitudVacaciones::where('id', $id)->delete();
            if ($deleted) {
                $response = array(
                    'status' => 200,
                    'message' => 'La solcitud se ha eliminado correctamente'
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
        $diaFeriado = solicitudVacaciones::find($id);
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
