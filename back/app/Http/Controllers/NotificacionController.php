<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\Usuario;
use App\Models\NotificacionEliminada;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    //-------------------------------------------------
    //LISTAR LAS NOTIFICACIONES DEL USUARIO AUTENTICADO
    //-------------------------------------------------
    public function index() {

        $user = Auth::user();

        //Obtenemos IDs de la notificaciones eliminadas 
        $eliminadas = NotificacionEliminada::where('usuario_id', $user->id)
            ->pluck('notificacion_id');

        //Notificaciones generales + individuales
        $notificaciones = Notificacion::where(function ($q) use ($user) {
                $q->whereNull('tutor_id')
                  ->orWhere('tutor_id', $user->id);
            })
            ->whereNotIn('id', $eliminadas)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notificaciones);
    }

    //-------------------------------------------------
    //CREAR NOTIFICACION (solo admin/empleado)
    //-------------------------------------------------
    public function store(Request $request) {

        //Autorización
        if(!in_array(Auth::user()->rol, ['admin', 'empleado'])) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        //Validación
        $request->validate([
            'tutor_id' => 'nullable|exists:usuarios,id',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo' => 'required|in:general,individual,evento,clase,aviso',
            'subtipo' => 'nullable|string|max:255',
        ]);

        //Crear notificación
        $notificacion = Notificacion::create([
            'tutor_id' => $request->tutor_id,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'tipo' => $request->tipo,
            'subtipo' => $request->subtipo,
            'leida' =>false,
            'creado_por' => Auth::id(),
        ]);

        return response()->json($notificacion, 201);
    }

    //-------------------------------------------------
    //MARCAR NOTIFICACIÓN COMO LEÍDA
    //-------------------------------------------------
    public function marcarLeida($id){
        $user = Auth::user();

        //Buscar las notificaciones que pertenezcan al usuario
        $notificacion = Notificacion::where('id', $id)
            ->where(function($q) use ($user){
                $q->whereNull('tutor_id')
                  ->orWhere('tutor_id', $user->id);
            })
            ->first();
        
        if(!$notificacion){
            return response()->json(['error' => 'Notificación no encontrada'], 404);
        }

        //Marcar como leída
        $notificacion->leida = true;
        $notificacion->save();

        return response()->json(['message' => 'Notificación marcada como leída']);
    }

    //-------------------------------------------------
    //CONTAR NOTIFICACIONES NO LEIDAS
    //-------------------------------------------------
    public function contarNoLeidas(){
        $user = Auth::user();

        $count = Notificacion::where('leida', false)
            ->where(function ($q) use ($user){
                $q->whereNull('tutor_id')
                  ->orWhere('tutor_id', $user->id);
            })
            ->count();

        return response()->json(['no_leidas' => $count]);
    }

    //-------------------------------------------------
    //ELIMINAR NOTIFICACIONES
    //-------------------------------------------------
    public function destroy($id){

        $user = Auth::user();

        //Buscamos la notificación
        $notificacion = Notificacion::find($id);

        if(!$notificacion){
            return response()->json(['error' => 'Notificación no encontrada.'], 404);
        }

        //Verificar si la notificación pertenece al usuario o es general 
        if(!is_null($notificacion->tutor_id) && $notificacion->tutor_id !== $user->id) {
            return response()->json(['error' => ' No autorizado.'], 403);
        }

        //Registrar que el usuario la ha eliminado
        NotificacionEliminada::firstOrCreate([
            'usuario_id' => $user->id,
            'notificacion_id' => $notificacion->id,
        ]);

        return response()->json(['message' => 'Notificación eliminada correctamente.']);
    }

    //-------------------------------------------------
    //MARCAR NOTIFICACIONES COMO LEÍDAS 
    //-------------------------------------------------
    public function marcarTodasLeidas(){

        $user = Auth::user();

        //IDs de notificaciones eliminadas por usuario
        $eliminadas = NotificacionEliminada::where('usuario_id', $user->id)
            ->pluck('notificacion_id');

        //Marcar como eídas todas las visibles 
        Notificacion::where(function ($q) use ($user){
                $q->whereNull('tutor_id')
                  ->orWhere('tutor_id', $user->id);
            })
            ->whereNotIn('id', $eliminadas)
            ->update(['leida' =>true]);

        return response()->json(['message' => 'Todas las notificaciones han sido marcadas como leídas.']);
    }

    //-------------------------------------------------
    //ELIMINAR TODAS LAS NOTIFICACIONES
    //-------------------------------------------------
    public function eliminarTodas(){

        $user = Auth::user();

        //IDs de notificaciones eliminadas por el usuario
        $eliminadas = NotificacionEliminada::where('usuario_id', $user->id)
            ->pluck('notificacion_id');

        //IDs de notificaciones visibles 
        $visibles = Notificacion::where(function ($q) use ($user){
                $q->whereNull('tutor_id')
                  ->orWhere('tutor_id', $user->id);
            })
            ->whereNotIn('id', $eliminadas)
            ->pluck('id');
            
        //Registrar todas las eliminadas 
        foreach($visibles as $id){
            NotificacionEliminada::firstOrCreate([
                'usuario_id' => $user->id,
                'notificacion_id' => $id,
            ]);
        }

        return response()->json(['message' => 'Todas las notificaciones han sido eliminadas.']);
    }
}
