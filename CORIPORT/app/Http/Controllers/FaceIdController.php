<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaceId;
use App\Models\Marca;

class FaceIdController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'store', 'update', 'delete']]);
    }

    public function index()
    {
        $data = Marca::with('horario', 'empleado', 'empleado.usuario', 'empleado.puesto')->get();

        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data,
        ];

        return response()->json($response, 200);
    }


    public function showByDate()
    {
        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d');
        $tipo = 'Salida';
    
        $marca = Marca::where('fecha', $fecha)->where('tipo', $tipo)->get();
    
        if ($marca->isEmpty()) {
            $response = [
                'status' => 404,
                'message' => 'Marca no encontrada',
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Consulta generada exitosamente',
                'data' => $marca
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
                // Validar los datos
                $rules = [
                    'idEmpleado' => 'required|int',
                    'imageData' => 'required|string|base64image',
                    'descriptor' => 'required|array'
                ];
                $validator = \Validator::make($data, $rules);
    
                if (!$validator->fails()) {
                    // Obtener y guardar la imagen
                    $imageData = $data['imageData'];
                    $filename = \Str::uuid() . '.png'; // Nombre de archivo único
                    \Storage::disk('users')->put($filename, base64_decode($imageData));
    
                    // Crear una nueva instancia de FaceId y guardar en la base de datos
                    $faceId = new FaceId();
                    $faceId->imageData = $filename;
                    $faceId->descriptor = json_encode($data['descriptor']);
                    $faceId->idEmpleado = $data['idEmpleado'];

                    $faceId->save();
    
                    $response = [
                        'status' => 200,
                        'message' => 'Datos guardados exitosamente'
                    ];
                } else {
                    $response = [
                        'status' => 406,
                        'message' => 'Error en la validación de los datos',
                        'errors' => $validator->errors()
                    ];
                }
            } else {
                $response = [
                    'status' => 406,
                    'message' => 'Datos requeridos'
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Error al guardar los datos',
                'error' => $e->getMessage()
            ];
        }
    
        return response()->json($response, $response['status']);
    }
    

    public function uploadImage(Request $request)
    {
        $isValid = \Validator::make(
            $request->all(),
            ['file0' => 'required|image|mimes:jpg,jpeg,png,gif,svg']
        );
        if (!$isValid->fails()) {
            $image = $request->file('file0');
            $filename = \Str::uuid() . '.' . $image->getClientOriginalExtension();
            \Storage::disk('users')->put($filename, \File::get($image));
            $response = array(
                "status" => 201,
                "message" => "Imagen guardada correctamente",
                "filename" => $filename,
            );
        } else {
            $response = array(
                "status" => 406,
                "message" => "Error: no se encontro la imagen",
                "errors" => $isValid->errors()
            );
        }
        return response()->json($response, $response['status']);
    }

    public function getImage($filename)
    {
        if (isset($filename)) {
            $exist = \Storage::disk('users')->exists($filename);
            if ($exist) {
                $file = \Storage::disk('users')->get($filename);
                return new Response($file, 200);
            } else {
                $response = array(
                    "status" => 404,
                    "message" => "No Existe la imagen"
                );
            }
        } else {
            $response = array(
                "status" => 406,
                "message" => "No se definio el nombre de la imagen"
            );
        }
        return response()->json($response);
    }

    public function update(Request $request, $id)
    { {
            $dataInput = $request->input('data', null);
            $data = json_decode($dataInput, true);

            if (empty($data)) {
                $response = array(
                    'status' => 400,
                    'message' => 'Datos no proporcionados o incorrectos',
                );
            } else {
                $rules = [
                    'tipo' => 'required',
                    'idHorario' => 'required|int',
                    'idEmpleado' => 'required|int',
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
                        $marca = Marca::find($id);

                        if ($marca) {
                            $marca->update($data);

                            $response = array(
                                'status' => 200,
                                'message' => 'Datos actualizados satisfactoriamente',
                            );
                        } else {
                            $response = array(
                                'status' => 400,
                                'message' => 'La marca no existe',
                            );
                        }
                    } else {
                        $response = array(
                            'status' => 400,
                            'message' => 'El ID de la marca no es válido',
                        );
                    }
                }
            }

            return response()->json($response, $response['status']);
        }
    }
    public function delete($id)
    {
        $marca = Marca::find($id);
        if ($marca) {
            $marca->delete();
            $response = [
                'status' => 200,
                'message' => 'Marca eliminada correctamente',
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'No se pudo eliminar la marca, puede ser que no exista',
            ];
        }

        return response()->json($response, $response['status']);
    }
    
}
