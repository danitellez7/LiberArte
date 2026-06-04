<?php

namespace App\Http\Controllers;

use App\Models\Nino;
use Illuminate\Http\Request;

class NinoController extends Controller
{
    public function storeFromAdmin(Request $request){

        $request->validate([
            'tutor_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'nullable|string',
            'alergias' => 'nullable|string',
            'observaciones' => 'nullable|string'
        ]);

        $nino = Nino::create([
            'tutor_id' => $request->tutor_id,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
            'alergias' => $request->alergias,
            'observaciones' => $request->observaciones,
        ]);

        return response()->json($nino, 201);
    }

    public function destroyFromAdmin($id){
        $nino = Nino::find($id);

        if(!$nino){
            return response()->json(['error' => 'Niño no encontrado'], 404);
        }

        $nino->delete();

        return response()->json(['message' => 'Niño eliminado correctamente']);
    }

    public function ninosPorTutor($id){

        return Nino::where('tutor_id', $id)->get();
    }
}
