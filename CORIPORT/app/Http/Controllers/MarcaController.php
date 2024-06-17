<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => [ 'showByEmpleado', 'index', 'showSalida', 'showByDate', 'store', 'update', 'delete']]);
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

    public function showSalida()
    {
        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d');
        $tipo = 'salida';

        $marca = Marca::where('fecha', $fecha)
            ->where('tipo', $tipo)
            ->pluck('idMarca');

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

    public function showByDate()
    {
        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d');
        $tipo = 'Salida';

        $marca = Marca::where('fecha', $fecha)->where('tipo', $tipo)->get();
        if ($marca) {
            $marca->load('empleado');
        }
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
                $data = array_map('trim', $data);
                $rules = [
                    'tipo' => 'required',
                    'idHorario' => 'required|int',
                    'idEmpleado' => 'required|int',

                ];
                $valid = \validator($data, $rules);

                if (!$valid->fails()) {
                    date_default_timezone_set('America/Costa_Rica');

                    $marca = new Marca();
                    $marca->fecha = date('Y-m-d');
                    $marca->hora = now()->format('H:i:s');
                    $marca->tipo = $data['tipo'];
                    $marca->idHorario = $data['idHorario'];
                    $marca->idEmpleado = $data['idEmpleado'];

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

    public function showByEmpleado($idEmpleado)
    {
        $marcas = Marca::where('idEmpleado', $idEmpleado)->with('horario')->get();

        $horarios = $marcas->pluck('horario');

        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $horarios,
        ];

        return response()->json($response, 200);
    }
}
