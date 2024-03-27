<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroTardia;


class RegistroTardiaController extends Controller{
    public function __construct(){
        $this->middleware('api.auth', ['except' => ['index','show', 'store', 'delete','update']]);
    }

    public function index()
    {
        // Recuperar todas las justificaciones de ausencia
        $data = RegistroTardia::all();
    
        // Verificar si se encontraron datos
        if ($data->isEmpty()) {
            $response = [
                "status" => 404,
                "message" => "No se encontraron justificaciones de ausencia",
                "data" => [],
            ];
        } else {
            // Cargar relaciones relacionadas con los registros de ausencia,
            // empleados, usuarios y puestos
            $data->load('empleado', 'justificacionAusencia');
    
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
}