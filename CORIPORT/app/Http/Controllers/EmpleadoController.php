<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    public function __construct(){
        $this->middleware('api.auth', ['except' => ['index','show', 'store', 'delete','update']]);
    }

    public function index()
    {
        $data = Empleado::all();
        if ($data) {
            $data->load('usuario', 'puesto');
        }
        $response = [
            "status" => 200,
            "message" => "Consulta generada exitosamente",
            "data" => $data,
        ];
        return response()->json($response, 200);
    }

    public function show($id)
    {
        $empleado = Empleado::find($id);
        if (is_object($empleado)) {
            $empleado->load('usuario', 'puesto');
            $response = [
                'status' => 200,
                'data' => $empleado,
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Empleado no encontrado',
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function store(Request $request)
    {
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);
        $data = array_map('trim', $data);
        $rules = [
            'nombre' => 'required|alpha',
            'apellido1' => 'required|alpha',
            'apellido2' => 'required|alpha',
            'telefono1' => 'required|integer',
            'telefono2' => 'required|integer',
            'cedula' => 'required',
            'fechContrat' => 'required|date_format:Y-m-d',
            'idUsuario' => 'required|integer',
            'idPuesto' => 'required|integer',
        ];
        $valid = validator($data, $rules);
        if (!$valid->fails()) {
            $empleado = new Empleado();
            $empleado->nombre = $data['nombre'];
            $empleado->apellido1 = $data['apellido1'];
            $empleado->apellido2 = $data['apellido2'];
            $empleado->telefono1 = $data['telefono1'];
            $empleado->telefono2 = $data['telefono2'];
            $empleado->cedula = $data['cedula'];
            $empleado->fechContrat = $data['fechContrat'];
            $empleado->idUsuario = $data['idUsuario'];
            $empleado->idPuesto = $data['idPuesto'];
            $empleado->save();
            $empleado->load('usuario', 'puesto');
            $response = [
                'status' => 200,
                'message' => 'Datos guardados exitosamente',
                'data' => $empleado,
            ];
        } else {
            $response = [
                'status' => 406,
                'message' => 'Error en la validación de los datos',
                'errors' => $valid->errors(),
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function update(Request $request, $id)
    {
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);
        $data = array_map('trim', $data);
        $rules = [
            'nombre' => 'required|alpha',
            'apellido1' => 'required|alpha',
            'apellido2' => 'required|alpha',
            'telefono1' => 'required|integer',
            'telefono2' => 'required|integer',
            'cedula' => 'required',
            'fechContrat' => 'required|date_format:Y-m-d',
            'idUsuario' => 'required|integer|min:1',
            'idPuesto' => 'required|integer|min:1',
        ];
        $valid = validator($data, $rules);
        if ($valid->fails()) {
            $response = [
                'status' => 406,
                'message' => 'Datos enviados no cumplen con las reglas establecidas',
                'errors' => $valid->errors(),
            ];
        } else {
            
            $empleado = Empleado::find($id);
            if ($empleado) {
                $empleado->nombre = $data['nombre'];
                $empleado->apellido1 = $data['apellido1'];
                $empleado->apellido2 = $data['apellido2'];
                $empleado->telefono1 = $data['telefono1'];
                $empleado->telefono2 = $data['telefono2'];
                $empleado->cedula = $data['cedula'];
                $empleado->fechContrat = $data['fechContrat'];
                $empleado->idUsuario = $data['idUsuario'];
                $empleado->idPuesto = $data['idPuesto'];
                $empleado->save();
                $empleado->load('usuario', 'puesto');
                $response = [
                    'status' => 200,
                    'message' => 'Datos actualizados satisfactoriamente',
                    'data' => $empleado,
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'No se pudo actualizar el empleado, puede ser que no exista',
                ];
            }
        }
        return response()->json($response, $response['status']);
    }

    public function delete($id)
    {
        if (isset($id)) {
            $empleado = Empleado::find($id);
            if ($empleado) {
                $empleado->delete();
                $response = [
                    'status' => 200,
                    'message' => 'Empleado eliminado correctamente',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'No se pudo eliminar el recurso',
                ];
            }
        } else {
            $response = [
                'status' => 400,
                'message' => 'Falta el identificador (id) del recurso a eliminar',
            ];
        }
        return response()->json($response, $response['status']);
    }
}