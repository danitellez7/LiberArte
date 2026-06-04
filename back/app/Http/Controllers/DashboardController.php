<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Actividad;

class DashboardController extends Controller
{
    public function stats(){

        return response()->json([
            'empleados' => Usuario::where('rol', 'empleado')->count(),
            'tutores' => Usuario::where('rol', 'tutor')->count(),
            'actividades' => Actividad::count(),
        ]);
    }
}
