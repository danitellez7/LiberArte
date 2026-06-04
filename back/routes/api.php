<?php

    use App\Http\Controllers\LoginController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\RegistroController;
    use App\Http\Controllers\PerfilController;
    use App\Http\Controllers\PagoController;
    use App\Http\Controllers\NotificacionController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\UsuarioController;
    use App\Http\Controllers\ActividadController;
    use App\Http\Controllers\NinoController;
    use App\Http\Controllers\ClaseEmpleadoController;
    use App\Http\Controllers\InscripcionController;


    //Ruta para comprobar que la API funciona
    Route::get('/test', function(){
        
        return response()->json(['message' => 'API funcionando']);
    });


    //----------------------------------------------------
    //LOGIN
    //----------------------------------------------------

    //Perfil del padre: Actualizar datos y foto
    Route::middleware('auth:sanctum')->post('/perfil/actualizar', [PerfilController::class, 'actualizar']);

    //Ruta login
    Route::post('/login', [LoginController::class, 'login']);

    //Ruta para prueba en Sactum
    Route::middleware('auth:sanctum')->get('/usuario', function(Request $request){
        return $request->user();
    });

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

    //Ruta para pagado correctamente
    Route::put('/pagos/{id}/pagar', [PagoController::class, 'pagar']);

    //Ruta paga crear un pago nuevo
    Route::post('/pagos/crear', [PagoController::class, 'crearPago']); 

    //Ruta para obtener pagos por DNI del tutor
    Route::get('/pagos/tutor/{dni}', [PagoController::class, 'obtenerPagosPorDni']);

    Route::get('/tutor/{id}/pagos', [PagoController::class, 'pagosTutor']);


     //-------------------------------------------------------
    //EMPLEADOS
    //-------------------------------------------------------

    //Ruta para empleados 
    Route::get('/admin/empleados/{id}/clases', [ClaseEmpleadoController::class, 'indexByEmpleado']);

    //Ruta de clases
    Route::post('/admin/empleados/{id}/clases', [ClaseEmpleadoController::class, 'store']);

    //Borrar clase
    Route::delete('/admin/clases/{id}', [ClaseEmpleadoController::class, 'destroy']);

    //Ruta para el tutor 
    Route::middleware('auth:sanctum')->get('/tutor/clases', [ClaseEmpleadoController::class, 'clasesTutor']);

    //-------------------------------------------------------
    //PANEL ADMIN: DASHBOARD
    //-------------------------------------------------------
    Route::get('/admin/dashboard', [DashboardController::class, 'stats']);

    //-------------------------------------------------------
    //PANEL ADMIN: USUARIOS 
    //-------------------------------------------------------
    Route::get('/admin/usuarios', [UsuarioController::class, 'index']);

    Route::get('/admin/usuarios/{id}', [UsuarioController::class, 'show']);

    Route::get('/admin/empleados', [UsuarioController::class, 'empleados']);

    Route::get('/admin/empleados/{id}', [UsuarioController::class, 'showEmpleado']);

    Route::post('/admin/empleados/{id}/contrato', [UsuarioController::class, 'subirContrato']);

    Route::get('/tutor/{id}', [UsuarioController::class, 'perfilTutor']);

    //-------------------------------------------------------
    //PANEL ADMIN: GESTION DE HIJOS
    //-------------------------------------------------------
    Route::post('/admin/ninos', [NinoController::class, 'storeFromAdmin']);
    

    Route::delete('/admin/ninos/{id}', [NinoController::class, 'destroyFromAdmin']);

    
    Route::get('/ninos/tutor/{id}', [NinoController::class, 'ninosPorTutor']);


    //-------------------------------------------------------
    //PANEL ADMIN: ACTIVIDADES
    //-------------------------------------------------------

    Route::get('/actividades', [ActividadController::class, 'index']);

    Route::post('/actividades', [ActividadController::class, 'store']);

    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy']);

    
    //-------------------------------------------------------
    //PANEL ADMIN: INSCRIPCIONES
    //-------------------------------------------------------

    Route::post('/inscripciones', [InscripcionController::class, 'store']);

    Route::get('/inscripciones', [InscripcionController::class, 'index']);

    Route::delete('/inscripciones/{id}', [InscripcionController::class, 'destroy']);

    Route::get('/tutor/{id}/actividades', [InscripcionController::class, 'actividadesTutor']);

    