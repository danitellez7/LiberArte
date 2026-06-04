<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use Illuminate\Support\Facades\Route;
use App\Models\Usuario;

//Ruta de login
Route::post('/login', [LoginController::class, 'login']);

//Ruta para mostrar formulario para reestrablecer contraseña
Route::get('/reset-password/{token}', [LoginController::class, 'mostrarFormularioReset']);

//Ruta para guardar la nueva contraseña
Route::post('/reset-password', [LoginController::class, 'guardarNuevaPassword']);


//----------------------------------
//ROLES
//----------------------------------

//Panel de ADMIN
Route::get('admin', function (){
    return view('admin.index');
})->middleware('rol:admin');

//Panel de EMPLEADO
Route::get('empleado', function (){
    return view('empleado.index');
})->middleware('rol:empleado');

//Panel de TUTOR
Route::get('tutor', function (){
    return view('tutor.index');
})->middleware('rol:tutor');
 