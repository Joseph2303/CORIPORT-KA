<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
    }

    public function __invoke()
    {
    }

    public function index()
    {
        $data = Usuario::all();
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
                'email' => 'required|email|unique:usuario',
                'contrasena' => 'required',
                'tipoUsuario' => 'required',
            ];
            $valid = \validator($data, $rules);
            if (!$valid->fails()) {
                $user = new Usuario();
                $user->email = $data['email'];
                $user->contrasena = hash('sha256', $data['contrasena']);
                $user->tipoUsuario = $data['tipoUsuario'];
                $user->save();
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

    public function update(Request $request, $id)
    {
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);

        if (empty($data)) {
            $response = array(
                'status' => 400,
                'message' => 'Datos no proporcionados o incorrectos',
            );
        } else {
            // Validar los datos
            $rules = [
                'email' => 'required|email',
                'tipoUsuario' => 'required',
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
                    $usuario = Usuario::find($id);

                    if ($usuario) {
                        // Actualiza los campos específicos
                        $usuario->update($data);

                        $response = array(
                            'status' => 200,
                            'message' => 'Datos actualizados satisfactoriamente',
                        );
                    } else {
                        $response = array(
                            'status' => 400,
                            'message' => 'El usuario no existe',
                        );
                    }
                } else {
                    $response = array(
                        'status' => 400,
                        'message' => 'El ID del usuario no es válido',
                    );
                }
            }
        }

        return response()->json($response, $response['status']);
    }



    public function delete($email)
    {
        if (isset($email)) {
            $deleted = Usuario::where('email', $email)->delete();
            if ($deleted) {
                $response = array(
                    'status' => 200,
                    'message' => 'Usuario eliminado correctamente'
                );
            } else {
                $response = array(
                    'status' => 400,
                    'message' => 'No se pudo eliminar el recurso'
                );
            }
        } else {
            $response = array(
                'status' => 400,
                'message' => 'Falta el identificador(email) del recurso a eliminar'
            );
        }
        return response()->json($response, $response['status']);
    }

    public function login(Request $request)
    {
        $jwtAuth = new JwtAuth();
        $dataInput = $request->input('data', null);
        $data = json_decode($dataInput, true);
        $data = array_map('trim', $data);
        $rules = ['email' => 'required', 'contrasena' => 'required'];
        $valid = \validator($data, $rules);
        if (!$valid->fails()) {
            $response = $jwtAuth->getToken($data['email'], $data['contrasena']);

            return response()->json($response);
        } else {
            $response = array(
                'status' => 406,
                'message' => 'Error en la validacion de datos',
                'errors' => $valid->errors(),
            );
            return response()->json($response, 406);
        }
    }

    public function getIdentity(Request $request)
    {
        $jwtAuth = new JwtAuth();
        $token = $request->header('beartoken');

        if (isset($token)) {
            $response = $jwtAuth->checkToken($token, true);
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Token (beartoken) no encontrado'
            );
        }
        return response()->json($response);
    }
    public function getId($id)
    {
        $user = Usuario::find($id);
        if (is_null($user)) {
            return response()->json(["message" => "Id del usuario no encontrado"], 404);
        } else {
            return response()->json($user::find($id), 200);
        }
    }

    public function getUserByEmail($email)
    {
        $user = Usuario::where('email', $email)->first();

        if (is_null($user)) {
            return response()->json(["message" => "Usuario no encontrado con el correo proporcionado"], 404);
        } else {
            return response()->json($user, 200);
        }
    }

    public function compareTokens(Request $request)
    {      
        $localStorageToken = $request->header('beartoken'); // Obtén el token del encabezado de la solicitud

        if(isset($localStorageToken)){
            $user = Usuario::where(['remember_token'=> $localStorageToken])->first(); // Busca el usuario correspondiente al token en la base de datos

            if ($user) {
                $response = [
                    'status' => 200,
                    'message' => 'Los tokens coinciden'
                ];
                
            } else {
                $response = [
                    'status' => 401,
                    'message' => 'Los tokens no coinciden'
                ];
            }
        }else{
            $response = [
                'status' => 401,
                'message' => 'token no encontrado'
            ];
        }
        return response()->json($response);
    }

}
