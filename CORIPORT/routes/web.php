<?php

use App\Http\Controllers\DiasFeriadosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\JustificacionAusenciaController;
use App\Models\JustificacionAusencia;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('api')->group(
    function(){

        //Route user      
        Route::get('/user/getidentity',[UserController::class,'getIdentity']);
        Route::get('/users',[UserController::class,'index']);
        Route::delete('/user/delete/{id}',[UserController::class,'delete']);
        Route::post('/user/login',[UserController::class,'login']);
        Route::post('/user/store',[UserController::class,'store']);
        Route::put('/user/update/{id}',[UserController::class,'update']);
        Route::get('/userId/{id}',[UserController::class,'getId']);
        Route::get('/user/{email}',[UserController::class,'getUserByEmail']);

        //Router Empleado
        Route::get('/empleados', [EmpleadoController::class, 'index']);
        Route::get('/empleado/show/{id}', [EmpleadoController::class, 'show']);
        Route::post('/empleado/store', [EmpleadoController::class, 'store']);
        Route::put('/empleado/update/{id}', [EmpleadoController::class, 'update']);
        Route::delete('/empleado/delete/{id}', [EmpleadoController::class, 'delete']);

        //Route Dias feriados
        Route::get('/dias_feriados', [DiasFeriadosController::class, 'index']);
        Route::get('/dias_feriados/show/{id}', [DiasFeriadosController::class, 'show']);
        Route::post('/dias_feriados/store', [DiasFeriadosController::class, 'store']);
        Route::put('/dias_feriados/update/{id}', [DiasFeriadosController::class, 'update']);
        Route::delete('/dias_feriados/delete/{id}', [DiasFeriadosController::class, 'delete']);

        //Route horario
        Route::get('/horarios', [HorarioController::class, 'index']);
        Route::get('/horario/show/{id}', [HorarioController::class, 'show']);
        Route::post('/horario/store', [HorarioController::class, 'store']);
        Route::put('/horario/update/{id}', [HorarioController::class, 'update']);
        Route::delete('/horario/delete', [HorarioController::class, 'delete']);

        // Puesto 
        Route::get('/puestos', [PuestoController::class, 'index']);
        Route::get('/puesto/show/{id}', [PuestoController::class, 'show']);
        Route::post('/puesto/store', [PuestoController::class, 'store']);
        Route::put('/puesto/update/{id}', [PuestoController::class, 'update']);
        Route::delete('/puesto/delete/{id}', [PuestoController::class, 'delete']);


        // Justificacion de ausencia 
        Route::get('/justificacionAusencias', [JustificacionAusenciaController::class, 'index']);
        Route::get('/justificacionAusencia/show/{id}', [JustificacionAusenciaController::class, 'show']);
        Route::post('/justificacionAusencia/store', [JustificacionAusenciaController::class, 'store']);
        Route::put('/justificacionAusencia/update/{id}', [JustificacionAusenciaController::class, 'update']);
        Route::delete('/justificacionAusencia/delete/{id}', [JustificacionAusenciaController::class, 'delete']);

    }

);