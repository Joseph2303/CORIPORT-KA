<?php

namespace App\Http\Controllers;

use App\Models\HorasExtra;
use Illuminate\Http\Request;

class HorasExtraController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show','calcularHorasExtra']]);
    }
    public function __invoke()
    {
    }

    public function index()
    {
        $data = HorasExtra::all();
        if ($data) {
            $response = array(
                "status" => 200,
                "message" => "Consulta generada exitosamente",
                "data" => $data
            );
        }
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $horasExtra = HorasExtra::find($id);
        if (is_object($horasExtra)) {
            $response = [
                'status' => 200,
                'data' => $horasExtra,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Hora Extra no encontrada',
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function calculateHorasExtras(Request $request)
    {
        $idEmpleado = $request->input('idEmpleado');
        $idMarca = $request->input('idMarca');

        try {
            DB::statement('EXEC CalcularHorasExtras ?, ?', [$idEmpleado, $idMarca]);
            $response = [
                'status' => 200,
                'message' => 'Horas extras calculadas correctamente',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Error al calcular horas extras',
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($response, $response['status']);
    }
}


