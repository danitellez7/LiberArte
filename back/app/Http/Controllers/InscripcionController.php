<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Actividad;
use App\Models\Nino;
use App\Models\Precio;

class InscripcionController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'tutor_id' => 'required|exists:usuarios,id',
            'nino_id' => 'required|exists:ninos,id',
            'actividad_id' => 'required|exists:actividades,id',
            'fecha_fin' => 'nullable|date',
        ]);

        $precio = Precio::where('actividad_id', $validated['actividad_id'])
                        ->where('estado', 'activa')
                        ->first();

        if (!$precio){
            return response()->json([
                'error' => 'No hay precio activo para esta actividad.'
            ], 422);
        }

        $inscripcion = Inscripcion::create([
            'tutor_id' => $validated['tutor_id'],
            'nino_id' => $validated['nino_id'],
            'actividad_id' => $validated['actividad_id'],
            'precio_id' => $precio->id,
            'estado' => 'activa',
            'fecha_fin' => $validated['fecha_fin'] ?? null,
            'fecha_inscripcion' => now(),
        ]);

        return response()->json([
            'message' => 'Nño inscrito correctamente',
            'inscripcion' => $inscripcion
        ], 201);
    }

    public function index(){

        return Inscripcion::with(['actividad', 'nino', 'tutor', 'precio'])->get();
    }

    public function destroy($id){
        
        $inscripcion = Inscripcion::find($id);

        if(!$inscripcion){
            return response()->json(['error' => 'Inscripción no encontrada'], 404);
        }

        $inscripcion->delete();

        return response()->json(['message' => 'Inscripción eliminada correctamente']);
    }

    public function actividadesTutor($id){

        return Inscripcion::with(['actividad', 'nino'])
            ->where('tutor_id', $id)
            ->get();
    }
}
