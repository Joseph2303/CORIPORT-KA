<?php
namespace app\Helpers;

use App\Models\Empleado;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Models\Usuario;

class JWTAuth{
    private $key;
    function __construct(){
        $this->key="Esta es mi clave secreta abc123";
    }
    public function getToken($email,$contrasena){
        $user = Usuario::where([
            'email' => $email,
            'contrasena' => hash('sha256', $contrasena)
        ])->with('empleado', 'empleado.puesto')->first();

        if(is_object($user)){
           
            $token=array(          
                'iss'=>$user->idUsuario,
                'email'=>$user->email,
                'contrasena'=>$user->contrasena,
                'tipoUsuario'=>$user->tipoUsuario,
                'empleado' =>  $user->empleado,
                'puesto' =>  $user->empleado->puesto,
                'iat'=>time(),
                'exp'=>time()+(2000)
            );
            $data=JWT::encode($token,$this->key,'HS256');
        }else{
            $data=array(
                'status'=>401,
                'message'=>'Datos de autenticación incorrectos'
            );
        }
        return $data;
    }
    public function checkToken($jwt,$getId=false){
        $auth=false;
        if(isset($jwt)){
            try{
                $decoded=JWT::decode($jwt,new Key($this->key,'HS256'));
            }catch(\DomainException $ex){
                $auth=false;
            }catch(\UnexpectedValueException $ex){
                $auth=false;
            }catch(ExpiredException $ex){
                $auth=false;
            }
            if(!empty($decoded)&&is_object($decoded)&&isset($decoded->iss)){
                $auth=true;
            }
            if($getId && $auth){
                return $decoded;
            }
        }
        return $auth;
    }
}
