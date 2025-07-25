<?php

use App\Http\Controllers\DiasFeriadosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FaceIdController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\JustificacionAusenciaController;
use App\Http\Controllers\JustificacionTardiaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\RegistroAusenciaController;
use App\Http\Controllers\RegistroTardiaController;
use App\Http\Controllers\soliVacacionesController;
use App\Http\Controllers\VacacionesController;
use App\Http\Controllers\HorasExtraController;
use App\Http\Controllers\HorariosEmpleadosController;

use App\Models\JustificacionTardia;
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
    function () {

        //Route user     
        Route::get('/user/comparetokens', [UserController::class, 'compareTokens']);
        Route::get('/user/getidentity', [UserController::class, 'getIdentity']);
        Route::get('/users', [UserController::class, 'index']);
        Route::delete('/user/delete/{id}', [UserController::class, 'delete']);
        Route::post('/user/login', [UserController::class, 'login']);
        Route::post('/user/store', [UserController::class, 'store']);
        Route::put('/user/update/{id}', [UserController::class, 'update']);
        Route::get('/userId/{id}', [UserController::class, 'getId']);
        Route::get('/user/{email}', [UserController::class, 'getUserByEmail']);


        //Router Empleado
        Route::get('/empleados', [EmpleadoController::class, 'index']);
        Route::get('/empleado/show/{id}', [EmpleadoController::class, 'show']);
        Route::get('/empleado/getEmpleado/{id}', [EmpleadoController::class, 'getEmpleado']);
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
        Route::get('/horario/showByDate', [HorarioController::class, 'showByDate']);
        Route::post('/horario/store', [HorarioController::class, 'store']);
        Route::put('/horario/update/{id}', [HorarioController::class, 'update']);
        Route::delete('/horario/delete', [HorarioController::class, 'delete']);
        Route::get('/horarios/{id}', [HorarioController::class, 'getHorarioPorEmpleado']);

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


        // Justificacion de ausencia 
        Route::get('/justificacionTardias', [JustificacionTardiaController::class, 'index']);
        Route::get('/justificacionTardia/show/{id}', [JustificacionTardiaController::class, 'show']);
        Route::post('/justificacionTardia/store', [JustificacionTardiaController::class, 'store']);
        Route::put('/justificacionTardia/update/{id}', [JustificacionTardiaController::class, 'update']);
        Route::delete('/justificacionTardia/delete/{id}', [JustificacionTardiaController::class, 'delete']);


        // Solicitud de vacaciones
        Route::get('/soliVacaciones', [soliVacacionesController::class, 'index']);
        Route::get('/soliVacaciones/showByEmpleado/{id}', [soliVacacionesController::class, 'showByEmpleado']);
        Route::post('/soliVacaciones/store', [soliVacacionesController::class, 'store']);
        Route::put('/soliVacaciones/update/{id}', [soliVacacionesController::class, 'update']);
        Route::put('/soliVacaciones/{id}', [soliVacacionesController::class, 'updateEmpleado']);
        Route::delete('/soliVacaciones/delete/{id}', [soliVacacionesController::class, 'delete']);
        Route::get('/soliVacaciones/{id}', [soliVacacionesController::class, 'getSolicitudVacacionesPorEmpleado']);

        // Registro de ausencias
        Route::get('/registroAusencias', [RegistroAusenciaController::class, 'index']);
        Route::get('/registroAusencia/show/{id}', [RegistroAusenciaController::class, 'show']);
        Route::post('/registroAusencia/store', [RegistroAusenciaController::class, 'store']);
        Route::put('/registroAusencia/update/{id}', [RegistroAusenciaController::class, 'update']);
        Route::delete('/registroAusencia/delete/{id}', [RegistroAusenciaController::class, 'delete']);
        Route::get('/registroAusencias/{id}', [RegistroAusenciaController::class, 'getRegistrosAusenciaPorEmpleado']);
        Route::get('/registroAusenciasEmpleado/show', [RegistroAusenciaController::class, 'registrosAusenciaEmpleado']);
  


        // Registro de tardias
        Route::get('/registroTardias', [RegistroTardiaController::class, 'index']);
        Route::get('/registroTardia/show/{id}', [RegistroTardiaController::class, 'show']);
        Route::post('/registroTardia/store', [RegistroTardiaController::class, 'store']);
        Route::put('/registroTardia/update/{id}', [RegistroTardiaController::class, 'update']);
        Route::delete('/registroTardia/delete/{id}', [RegistroTardiaController::class, 'delete']);
        Route::get('/registroTardias/{id}', [RegistroTardiaController::class, 'getRegistrosTardiaPorEmpleado']);
        Route::post('/registroTardiasEmpleado/show', [RegistroTardiaController::class, 'registrosTardiaEmpleado']);



        // Marcas
        Route::get('/marcas', [MarcaController::class, 'index']);
        Route::get('/marca/show/{id}', [MarcaController::class, 'show']);
        Route::post('/marca/store', [MarcaController::class, 'store']);
        Route::put('/marca/update/{id}', [MarcaController::class, 'update']);
        Route::delete('/marca/delete/{id}', [MarcaController::class, 'delete']);
        Route::delete('/marca/deleteByEmpleado/{id}', [MarcaController::class, 'delete']);
        Route::get('/marca/showByDate', [MarcaController::class, 'showByDate']);
        Route::get('/marca/showSalida', [MarcaController::class, 'showSalida']);
        Route::get('/marca/showByEmpleado/{id}', [MarcaController::class, 'showByEmpleado']);


        // Vacaciones 
        Route::get('/vacaciones', [VacacionesController::class, 'index']);
        Route::get('/vacaciones/{id}', [VacacionesController::class, 'getVacacionesPorEmpleado']);
        Route::get('/vacaciones/show/{id}', [VacacionesController::class, 'show']);
        Route::post('/vacaciones/store', [VacacionesController::class, 'store']);
        Route::put('/vacaciones/update/{id}', [VacacionesController::class, 'update']);
        Route::delete('/vacaciones/delete/{id}', [VacacionesController::class, 'delete']);

        // Horas Extra
        Route::get('/horasExtra', [HorasExtraController::class, 'index']);
        Route::get('/horasExtra/show/{id}', [HorasExtraController::class, 'show']);
        Route::get('/horasExtras/show', [HorasExtraController::class, 'calculateHorasExtras']);
        Route::get('/horasExtra/showByEmpleado/{id}', [HorasExtraController::class, 'showByEmpleado']);

       
        //face id
        Route::post('/faceId/store', [FaceIdController::class, 'store']);
        Route::get('/faceId/{id}', [FaceIdController::class, 'getDataById']);
        Route::get('/faceId', [FaceIdController::class, 'index']);
        Route::delete('/faceId/delete/{id}', [FaceIdController::class, 'delete']);


        //Horarios Empleado
        Route::get('/horarioEmpleado', [HorariosEmpleadosController::class, 'index']);
        Route::get('/horarioEmpleado/showByEmpleado/{id}', [HorariosEmpleadosController::class, 'showByEmpleado']);
        Route::post('/horarioEmpleado/store', [HorariosEmpleadosController::class, 'store']);
        Route::put('/horarioEmpleado/update/{id}', [HorariosEmpleadosController::class, 'update']);
        Route::delete('/horarioEmpleado/delete/{id}', [HorariosEmpleadosController::class, 'delete']);


    }

);
