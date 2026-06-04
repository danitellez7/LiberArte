<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller{

    public function login(Request $request){

        //-------------------------------------------------------
        //VALIDACIÓN DE DATOS
        //-------------------------------------------------------

        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        //-------------------------------------------------------
        //BUSCAR AL USUARIO
        //-------------------------------------------------------

        $user = Usuario::where('email', $request->email)->first();

        if(!$user){
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        //-------------------------------------------------------
        //COMPROBACIÓN DE CONTRASEÑA
        //-------------------------------------------------------

        if (!Hash::check($request->password, $user->password)){
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        //-------------------------------------------------------
        //GENERAMOS TOKEN PARA SANCTUM
        //-------------------------------------------------------

        $token = $user->createToken('auth_token')->plainTextToken;

        //-------------------------------------------------------
        //VALIDACIÓN DE DATOS
        //-------------------------------------------------------

        return response()->json([
            'message' => 'Login correcto',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'rol' => $user->rol,
                'nombre' => $user->nombre,
                'apellidos' => $user->apellidos,
            ]
        ]);
    }

    //-------------------------------------------------------
    //LOGOUT DEL USUARIO
    //-------------------------------------------------------
    public function logout(Request $request){

        //Obtenemos el token actual del usuario
        $token = $request->user()->currentAccessToken();

        //Eliminamos el token para cerrar para sesión
        $token->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.'
        ]);
    }

    //-------------------------------------------------------
    //REESTABLECER CONTRASEÑA USUARIO
    //-------------------------------------------------------
    public function enviarResetPassword(Request $request){

        //Validar el email
        $request->validate([
            'email' => 'required|email'
        ]);

        //Buscar al usuario
        $usuario = Usuario::where('email', $request->email)->first();

        if(!$usuario){
            return response()->json([
                'message' => 'Si el email existe, se enviará un enlace para reestablecer la contraseña.'
            ]);
        }

        //Generar token
        $token = Str::random(64);

        //Guardamos token y expiración
        $usuario->reset_token = $token;
        $usuario->reset_token_expires_at = now()->addHour();
        $usuario->save();

        //Construimos la URL del botón
        $url = url('/reset-password/' . $token);

        Mail::send('emails.reset_password', ['url' => $url], function ($message) use ($usuario){
            $message->to($usuario->email)
                    ->subject('Restablecer contraseña - Liberarte');
        });

        return response()->json([
            'message' => 'Si el email existe, se enviará un enlace para reestablecer la contraseña.'
        ]);
    }

    //-------------------------------------------------------
    //MOSTRAMOS EL FORMULARIO PARA RESETEAR LA CONTRASEÑA
    //-------------------------------------------------------
    public function mostrarFormularioReset($token){

        //Buscamos al usuario
        $usuario = Usuario::where('reset_token', $token)
                        ->where('reset_token_expires_at', '>', now())
                        ->first();
        
        if(!$usuario){
            return 'El enlace para restablecer la contraseña no es válido o ha expirado.';
        }

        //Mostrar la vista y pasar el token 
        return view('emails.reset_password_form', ['token' => $token]);
    }

    //-------------------------------------------------------
    //GUARDAMOS NUEVA CONTRASEÑA
    //-------------------------------------------------------
    public function guardarNuevaPassword(Request $request){

        //Validar datos
        $request->validate([
            'token'=> 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        //Buscamos al usuario
        $usuario = Usuario::where('reset_token', $request->token)
                          ->where('reset_token_expires_at', '>', now())
                          ->first();
        if(!$usuario){
            return 'El enlace para restablecer la contraseña no es válido o ha expirado.';
        }

        //Actualizar contraseña
        $usuario->password = Hash::make($request->password);

        //Borramos el token
        $usuario->reset_token = null;
        $usuario->reset_token_expires_at = null;

        $usuario->save();

        return 'Tu contraseña ha sido restablecida correctamente. Ya puedes iniciar sesión.';
    }
}