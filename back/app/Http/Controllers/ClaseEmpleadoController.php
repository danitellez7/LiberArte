<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClaseEmpleado;

class ClaseEmpleadoController extends Controller
{
    public function indexByEmpleado($empleadoId){

        $clases = ClaseEmpleado::with('nino')
            ->where('empleado_id', $empleadoId)
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return response()->json($clases);
    }

    public function store(Request $request, $empleadoId){

        //Validación
        $request->validate([
            'nino_id' => 'required|exists:ninos,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'estado' => 'required|in:pendiente,confirmada,cancelada',
        ]);

        //Crear clase
        $clase = ClaseEmpleado::create([
            'empleado_id' => $empleadoId,
            'nino_id' => $request->nino_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'estado' => $request->estado,
        ]);

        return response()->json($clase, 201);
    }

    public function destroy($id){
        $clase = ClaseEmpleado::find($id);

        if(!$clase){
            return response()->json(['error' => 'Clase no encontrada'], 404);
        }

        $clase->delete();

        return response()->json(['message' => 'Clase eliminada correctamente']);
    }

    public function ClasesTutor(){

        $tutor = auth()->user();

        //Niños del tutor
        $ninos = $tutor->ninosTutor->merge($tutor->ninos);

        //IDs de los niños
        $ninosIds = $ninos->pluck('id');

        //Clases de todos los niños
        $clases = ClaseEmpleado::with(['nino', 'empleado'])
            ->whereIn('nino_id', $ninosIds)
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return response()->json($clases);
    }
}
