<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show', 'store', 'update', 'delete']]);
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


    public function show($id)
    {
        $marca = Marca::find($id);
        if (is_object($marca)) {
            $response = [
                'status' => 200,
                'data' => $marca
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Marca no encontrado',
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
                    'fechaHora' => 'required|datetime',
                    'tipo' => 'required',
                    'idHorario' => 'required|int'
                ];
                $valid = \validator($data, $rules);

                if (!$valid->fails()) {
                    $marca = new Marca();
                    $marca->fechaHora = $data['fechaHora'];
                    $marca->tipo = $data['tipo'];
                    $marca->idHorario = $data['idHorario'];

                    $marca->save();
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
                'status' => 500,
                'message' => 'Error al guardar los datos',
                'error' => $e->getMessage(),
            );
        }

        return response()->json($response, $response['status']);
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
                    'fechaHora' => 'required|datetime',
                    'tipo' => 'required',
                    'idHorario' => 'required|int'

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
