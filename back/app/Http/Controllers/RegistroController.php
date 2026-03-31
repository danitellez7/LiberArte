<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Notifications\VerificarCuentaTutor;
use Illuminate\Support\Str;

class RegistroController extends Controller
{

    //--------------------------------------------------
    //PASO 1; VALIDACION DEL USUARIO
    //--------------------------------------------------
    public function paso1(Request $request){

        //Validación de email y contraseña
        $request->validate([
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
        ]);

        //Creación del usuario
        $user = Usuario::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'tutor',
        ]);

        //Generamos el token
        $user->generarTokenVerificacion();

        //Construimos la URL
        $url = url('/api/verificar/' . $user->verification_token);
        
        //Enviar el email personalizado
        $user->notify(new VerificarCuentaTutor($url));

        //Generamos token Sanctum para autenticar al usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        //Enviamos respuesta
        return response()->json([
            'message' => 'Usuario creado correctamente. Revisa tu email para verificar la cuenta.',
            'token' => $token,
            'user' => $user
        ]);
    }

    //--------------------------------------------------
    //VERIFICAR CUENTA
    //--------------------------------------------------
    public function verificarCuenta($token){

        //Buscamos al usuario
        $usuario = Usuario::where('verification_token', $token)->first();

        if(!$usuario){
            return response()->json([
                'message' => 'Token inválido'
            ], 404);
        }

        //Comprobar si el token ha expirado
        if(now()->greaterThan($usuario->verification_token_expires_at)){

            //Generar un nuevo token
            $nuevoToken = Str::random(64);
            $usuario->verification_token = $nuevoToken;
            $usuario->verification_token_expires_at = now()->addDay();
            $usuario->save();

            //Enviamos un nuevo email
            $url = url('/api/verificar/' . $nuevoToken);
            $usuario->notify(new VerificarCuentaTutor($url));

            //Respuesta Json
            return response()->json([
                'message' => 'El token ha expirado. Se ha enviado un nuevo enlace de verificación de correo.'
            ], 404);
        }

        //Verificar la cuenta
        $usuario->email_verified_at = now();
        $usuario->verification_token = null;
        $usuario->verification_token_expires_at = null;
        $usuario->save();

        return response()->json([
            'message' => 'Cuenta verificada correctamente.'
        ], 200);
    }

    //--------------------------------------------------
    //PASO 2; RELLENAR CAMPOS
    //--------------------------------------------------

    public function paso2(Request $request){

        //--------------------------------------------------
        //Obtenemos al usuario autenticado
        //--------------------------------------------------
        $user = $request->user();
            
        //--------------------------------------------------
        //Validamos datos
        //--------------------------------------------------
         $request->validate([
                'nombre' => 'nullable|string|max:255',
                'apellidos' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:255',
                'dni' => 'nullable|string|max:20',
            ]);

        //--------------------------------------------------
        //Actualizamos al usuario
        //--------------------------------------------------
        $user->update([
                'nombre' =>$request->nombre,
                'apellidos' =>$request->apellidos,
                'telefono' =>$request->telefono,
                'direccion' =>$request->direccion,
                'dni' =>$request->dni,
            ]);

        //--------------------------------------------------
        //Respuesta
        //--------------------------------------------------
        return response()->json([
            'message' => 'Datos completados correctamente',
            'user' => $user
        ]);
    }

    
}
