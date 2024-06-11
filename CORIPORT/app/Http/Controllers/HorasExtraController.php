<?php

namespace App\Http\Controllers;

use App\Models\HorasExtra;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class HorasExtraController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['index', 'show','calculateHorasExtras']]);
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

    public function calculateHorasExtras()    {
        try {
            DB::statement('EXEC paCalcularHorasExtras');

            $response = [
                'status' => 200,
                'message' => 'Horas calculadas correctamente',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Error al ejecutar el procedimiento almacenado',
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($response, $response['status']);
    }

}


