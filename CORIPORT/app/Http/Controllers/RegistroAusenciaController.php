<?php

namespace App\Http\Controllers;

use App\Models\RegistroAusencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroAusenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['getRegistrosAusenciaPorEmpleado', 'index', 'show', 'store', 'delete', 'update','registroAusenciasEmpleado']]);
    }

    public function index()
    {
        $data = RegistroAusencia::all();

        // Verificar si se encontraron datos
        if ($data->isEmpty()) {
            $response = [
                "status" => 404,
                "message" => "No se encontraron registros",
                "data" => [],
            ];
        } else {
            // Cargar relaciones relacionadas con los registros,
            $data->load('empleado', 'empleado.usuario', 'empleado.puesto', 'justificacionAusencia');

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

    public function getRegistrosAusenciaPorEmpleado($idEmpleado = null)
    {
        // Construir la consulta de registros de tardía
        $query = RegistroAusencia::query();

        // Aplicar filtro si se proporciona un idEmpleado
        if ($idEmpleado !== null) {
            $query->where('idEmpleado', $idEmpleado);
        }

        // Obtener los registros de tardía con relaciones cargadas
        $data = $query->with('empleado', 'empleado.usuario', 'empleado.puesto', 'justificacionAusencia')->get();

        // Preparar la respuesta
        $response = [
            "status" => $data->isEmpty() ? 404 : 200,
            "message" => $data->isEmpty() ? "No se encontraron justificaciones de tardía" : "Consulta generada exitosamente",
            "data" => $data,
        ];

        // Devolver la respuesta en formato JSON
        return response()->json($response);
    }

    public function show($id)
    {
        $registro = RegistroAusencia::find($id);
        if (is_object($registro)) {
            $response = [
                'status' => 200,
                'data' => $registro,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Registro no encontrado',
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
                    'fecha' => 'required|date',
                    'hora' => 'required|time',
                    'idEmpleado' => 'required|int'
                ];
                $valid = \validator($data, $rules);

                if (!$valid->fails()) {
                    $registro = new RegistroAusencia();
                    $registro->fecha = $data['fecha'];
                    $registro->hora = $data['hora'];
                    $registro->idEmpleado = $data['idEmpleado'];

                    $registro->save();
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
                    'idJustificacionAusencia' => 'required|int',
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
                        $registro = RegistroAusencia::find($id);

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
    public function delete($id)
    {
        $registro = RegistroAusencia::find($id);
        if ($registro) {
            $registro->delete();
            $response = [
                'status' => 200,
                'message' => 'Registro eliminado correctamente',
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'No se pudo eliminar el registro, puede ser que no exista',
            ];
        }

        return response()->json($response, $response['status']);
    }

    public function registroAusenciasEmpleado(Request $request)
    {
        $idEmpleado = $request->input('idEmpleado');
        $idMarca = $request->input('idMarca');

        try {
            DB::statement('EXEC RegistrarAusencia ?, ?', [$idEmpleado, $idMarca]);
            $response = [
                'status' => 200,
                'message' => 'Registro de ausencia realizado correctamente',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Error al registrar ausencia',
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($response, $response['status']);
    }

}
