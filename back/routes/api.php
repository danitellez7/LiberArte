<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PagoController;


//Ruta para comprobar que la API funciona
Route::get('/test', function(){
    
    return response()->json(['message' => 'API funcionando']);
});

Route::middleware('auth:sanctum')->get('/yo', function () {
    return auth()->user();
});


//----------------------------------------------------
//LOGIN
//----------------------------------------------------

//Paso 1: Crear usuario(email + contraseña)
Route::post('/registro/paso1', [RegistroController::class, 'paso1']);

//Paso 2: Completar los datos obligatorios del usuario autenticado
Route::middleware('auth:sanctum')->post('/registro/paso2', [RegistroController::class, 'paso2']);

//Perfil del padre: Actualizar datos y foto
Route::middleware('auth:sanctum')->post('/perfil/actualizar', [PerfilController::class, 'actualizar']);

//Ruta login
Route::post('/login', [LoginController::class, 'login']);

//Ruta para prueba en Sactum
Route::middleware('auth:sanctum')->get('/usuario', function(Request $request){
    return $request->user();
});

//Ruta Verificacion de token  (Botón verificar de email)
Route::get('/verificar/{token}', [RegistroController::class, 'verificarCuenta']);

//Ruta protegida para logout
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

//Ruta para reestablecer contraseña 
Route::post('/forgot-password', [LoginController::class, 'enviarResetPassword']);

//Ruta para guardar la contraseña nueva
Route::post('/reset-password', [LoginController::class, 'guardarNuevaPassword']);

//-------------------------------------------------------
//PAGOS
//-------------------------------------------------------

//Rutas para pagos
Route::apiResource('pagos', PagoController::class);

//Rutas para pagos de un tutor concreto
Route::get('tutores/{tutor}/pagos', [PagoController::class, 'pagoPorTutor']);

//Ruta para pagos por tutor y mes
Route::get('tutores/{tutor}/pagos/{mes}', [PagoController::class, 'pagoPorTutorYMes']);

//Ruta para deudas totales del tutor
Route::get('tutores/{tutor}/deuda', [PagoController::class, 'deudaTutor']);

//Ruta para mis pagos en concreto
Route::middleware('auth:sanctum')->get('/mis-pagos', [PagoController::class, 'misPagos']);



