<?php

use App\Models\raza;
use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


//Usuario
/*
Route::get('usuario', function(){
    return usuario::all();});

Route::get('usuario/{id}', function($id){
    return usuario::find($id);});

Route::post('usuario', function(Request $request){
    return usuario::create($request->all());});

Route::put('usuario/{id}', function(Request $request, $id){
    $usuario = usuario::findOrFail($id);
    $usuario->update($request->all());
    return $usuario;});

Route::delete('usuario/{id}', function($id){
    usuario::find($id)->delete();
    return 204;});


//Raza
Route::get('raza', function(){
    return raza::all();});

Route::get('raza/{id}', function($id){
    return raza::find($id);});

Route::post('raza', function(Request $request){
    return raza::create($request->all());});

Route::put('raza/{id}', function(Request $request, $id){
    $raza = raza::findOrFail($id);
    $raza->update($request->all());
    return $raza;});

Route::delete('raza/{id}', function($id){
    raza::find($id)->delete();
    return 204;});
    * */