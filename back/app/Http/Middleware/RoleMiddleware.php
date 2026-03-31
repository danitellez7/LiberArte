<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    //Maneja la petición y comprueba si el usuario tiene uno de los roles permitidos 
    public function handle(Request $request, Closure $next, ...$roles)
    {

        //Obtenemos al usuario autenticado
        $user = Auth::user();

        //Si no hay usuario logeado lo mandamos al login
        if(!$user){
            return redirect('/login');
        }

        //Si el rol está autenticado puede pasar
        if(in_array($user->rol, $roles)){
            return $next($request);
        }

        //Si no tiene permisos, lo redirigimos a su panel correspondiente
        return match($user->rol){
            'admin' => redirect('/admin'),
            'empleado' => redirect('/empleado'),
            'tutor' => redirect('/tutor'),
            default => redirect('/login'),
        };
    }
}
