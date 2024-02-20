<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show', 'store', 'delete', 'update']]);
    }

    public function __invoke()
    {
    }

    public function index()
    {
        $data = Horario::all();
        if ($data) {
            $data->load('empleado');
        }
        $response = array(
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data
        );
        return response()->json($response, 200);
    }


    public function store(Request $request)
    {
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);
        if (!empty($data)) {
            $data = array_map('trim', $data);
            $rules = [
                'idEmpleado' => 'required|int',

            ];
            $valid = \validator($data, $rules);
            if (!$valid->fails()) {
                date_default_timezone_set('America/Costa_Rica');

                $horario = new Horario();
                $horario->horaInicio =  now()->format('H:i:s');
                $horario->fecha = now();
                $horario->idEmpleado = $data['idEmpleado'];
                $horario->save();
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
        return response()->json($response, $response['status']);
    }

    public function update($idEmpleado)
    {


        date_default_timezone_set('America/Costa_Rica');
        $horafin = date('H:i:s');
        $fecha = date('Y-m-d');

        try {

            if (empty($idEmpleado)) {
                throw new \Exception('El ID del horario no es válido');
            }

            $horario = Horario::where('fecha', $fecha)
                ->where('idEmpleado', $idEmpleado)
                ->first();

            if (!$horario) {
                throw new \Exception('El horario no existe para la fecha y el empleado proporcionados');
            }



            $horario->horafin = $horafin;
            $horario->save();
            $horario->load('empleado');

            $response = [
                'status' => 200,
                'message' => 'Datos actualizados satisfactoriamente',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Error al actualizar los datos',
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($response, $response['status']);
    }





    public function delete(Request $request)
    {
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);
        if (!empty($data)) {
            $data = array_map('trim', $data);
            $rules = [
                'idEmpleado' => 'required|int',
                'fecha' => 'required|date',
            ];

            $valid = \validator($data, $rules);
            if (!$valid->fails()) {

                $deleted = Horario::where('fecha', $data['fecha'])
                    ->where('idEmpleado', $data['idEmpleado'])->delete();
                if ($deleted) {
                    $response = array(
                        'status' => 200,
                        'message' => 'Horario eliminado correctamente'
                    );
                } else {
                    $response = array(
                        'status' => 400,
                        'message' => 'No se pudo eliminar el recurso'
                    );
                }
            } else {
                $response = array(
                    'status' => 406,
                    'message' => 'Error en la validación de los datos',
                    'errors' => $valid->errors(),
                );
            }
        }
        return response()->json($response, $response['status']);
    }

    public function show($idEmpleado)
    {

        $horario = Horario::where('idEmpleado', $idEmpleado)->get();
        if (is_object($horario)) {
            $horario->load('empleado');
            $response = [
                'status' => 200,
                'data' => $horario,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Horario no encontrado',
            ];
        }
        return response()->json($response, $response['status']);
    }
}
