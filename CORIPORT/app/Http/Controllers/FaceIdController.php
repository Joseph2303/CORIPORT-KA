<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaceId;

class FaceIdController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['getDataById', 'index', 'store', 'update', 'delete']]);
    }

    public function index()
    {
        $data = FaceId::with('empleado', 'empleado.usuario', 'empleado.puesto')->get();

        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data,
        ];

        return response()->json($response, 200);
    }


    public function getDataById($idEmpleado)
    {
        try {

            $faceId = FaceId::where('idEmpleado', $idEmpleado)->first();

            if ($faceId) {

                $data = [
                    'idEmpleado' => $faceId->idEmpleado,
                    'imageData' => $faceId->imageData, 
                    'descriptor' => json_decode($faceId->descriptor, true) 
                ];

                return response()->json([
                    'status' => 200,
                    'message' => 'Datos y imagen recuperados exitosamente',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No se encontraron datos para el ID proporcionado'
                ]);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => 'Error al recuperar los datos',
                'error' => $e->getMessage()
            ]);
        }
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
                    // Obtener y decodificar la imagen
                    $imageData = $data['imageData'];
                    // $imageDecoded = base64_decode($imageData);

                    // Crear una nueva instancia de FaceId y guardar en la base de datos
                    $faceId = new FaceId();
                    $faceId->imageData = $imageData; // Guardar la imagen decodificada directamente
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
                        $marca = FaceId::find($id);

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
        $marca = FaceId::find($id);
        if ($marca) {
            $marca->delete();
            $response = [
                'status' => 200,
                'message' => 'FaceId eliminada correctamente',
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
