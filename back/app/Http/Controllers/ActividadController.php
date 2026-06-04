<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index(){
        
        return Actividad::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request){

        $validates = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'area_artistica' => 'required|string|max:255',
            'edad_minima' => 'nullable|integer|min:0',
            'edad_maxima' => 'nullable|integer|min:0',
            'duracion' => 'nullable|string|max:255',
            'estado' => 'required|in:activa,inactiva',
            'imagen' => 'nullable|string|max:255',
            'empleado_id' => 'nullable|exists:usuarios,id',
        ]);

        $actividad = Actividad::create($validates);

        return response()->json([
            'message' => 'Actividad creada correctamente',
            'actividad' => $actividad
        ], 201);
    }

    public function destroy($id){

        $actividad = Actividad::find($id);

        if(!$actividad){
            return response()->json(['error' => 'Actividad no encontrada'], 404);
        }

        $actividad->delete();

        return response()->json(['message' => 'Actividad eliminada correctamente']);

    }
}
