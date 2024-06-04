<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroTardia;
use Illuminate\Support\Facades\DB;

class RegistroTardiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['getRegistrosTardiaPorEmpleado','index', 'show', 'store', 'delete', 'update','registrosTardiaEmpleado']]);
    }

    public function index()
    {
        // Recuperar todas las justificaciones de ausencia
        $data = RegistroTardia::all();

        // Verificar si se encontraron datos
        if ($data->isEmpty()) {
            $response = [
                "status" => 404,
                "message" => "No se encontraron justificaciones de tardia",
                "data" => [],
            ];
        } else {
            // Cargar relaciones relacionadas con los registros de ausencia,
            // empleados, usuarios y puestos
            $data->load('empleado', 'empleado.usuario', 'empleado.puesto', 'justificacionTardia');

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

    public function getRegistrosTardiaPorEmpleado($idEmpleado = null)
    {
        // Construir la consulta de registros de tardía
        $query = RegistroTardia::query();

        // Aplicar filtro si se proporciona un idEmpleado
        if ($idEmpleado !== null) {
            $query->where('idEmpleado', $idEmpleado);
        }

        // Obtener los registros de tardía con relaciones cargadas
        $data = $query->with('empleado', 'empleado.usuario', 'empleado.puesto', 'justificacionTardia')->get();

        // Preparar la respuesta
        $response = [
            "status" => $data->isEmpty() ? 404 : 200,
            "message" => $data->isEmpty() ? "No se encontraron justificaciones de tardía" : "Consulta generada exitosamente",
            "data" => $data,
        ];

        // Devolver la respuesta en formato JSON
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
                    'idJustificacionTardia' => 'required|int',
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
                        $registro = RegistroTardia::find($id);

                        if ($registro) {
                            $registro->update($data);

                            $response = array(
                                'status' => 200,
                                'message' => 'Datos actualizados satisfactoriamente',
                            );
                        } else {
                            $response = array(
                                'status' => 400,
                                'message' => 'El registro no existe',
                            );
                        }
                    } else {
                        $response = array(
                            'status' => 400,
                            'message' => 'El ID del registro no es válido',
                        );
                    }
                }
            }

            return response()->json($response, $response['status']);
        }
    }

    public function registrosTardiaEmpleado(Request $request)
    {
        $idEmpleado = $request->input('idEmpleado');
        $idMarca = $request->input('idMarca');

        try {
            DB::statement('EXEC RegistrarTardia ?, ?', [$idEmpleado, $idMarca]);
            $response = [
                'status' => 200,
                'message' => 'Registro de tardía realizado correctamente',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Error al registrar tardía',
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($response, $response['status']);
    }


}
