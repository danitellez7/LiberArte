<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\ClaseEmpleado;
use Carbon\Carbon;
use App\Models\Inscripcion;

class UsuarioController extends Controller
{
    public function index(){

        $usuarios = Usuario::where('rol', 'tutor')
            ->with([
                'ninosTutor',
                'ninos',
                'pagos',
                'actividades'
            ])
            ->get();

        $resultado = $usuarios->map(function($u){

            $ninos = $u->ninosTutor->merge($u->ninos);
            $ninosIds = $ninos->pluck('id');

            $tieneClases = ClaseEmpleado::whereIn('nino_id', $ninosIds)->exists();

            return[
                'id' => $u->id,
                'nombre' => $u->nombre,
                'apellidos' => $u->apellidos,

                'ninos' => $u->ninosTutor->count(),

                'edades' => $ninos->map(function($nino){
                    return Carbon::parse($nino->fecha_nacimiento)->age;
                }),

                'actividades' => $u->actividades->pluck('nombre')->toArray(),

                'pagos' => $u->pagos->count(),

                'tiene_clases' => $tieneClases,
            ];
        });

        return response()->json($resultado);
    }

    public function show($id){

        $usuario = Usuario::with([
            'ninosTutor',
            'ninos',
            'pagos',
            'actividades'
        ])->findOrFail($id);

        $ninos = $usuario->ninosTutor->merge($usuario->ninos)->map(function($n){
            return[
                'id' => $n->id,
                'nombre' => $n->nombre,
                'apellidos' => $n->apellidos,
                'edad' => \Carbon\Carbon::parse($n->fecha_nacimiento)->age,
                'sexo' => $n->sexo,
                'alergias' => $n->alergias,
                'observaciones' => $n->observaciones

            ];
        });

        $pagos = $usuario->pagos->map(function($p){
            return[
                'id' => $p->id,
                'mes' => $p->mes,
                'descuento_aplicado' => $p->descuento_aplicado,
                'total_sin_descuento' => $p->total_sin_descuento,
                'total_final' => $p->total_final,
                'estado' => $p->estado,
                'metodo_pago' => $p->metodo_pago,
                'fecha_pago' => $p->fecha_pago,
                'notas' => $p->notas,
            ];
        });

        $actividades = $usuario->actividades->unique('id')->values()->map(function($a){
            return[
                'id' => $a->id,
                'nombre' => $a->nombre,
                'descripcion' => $a->descripcion
            ];
        });

        $inscripciones = Inscripcion::with('nino', 'actividad')
            ->where('tutor_id', $usuario->id)
            ->get();

        return response()->json([
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'dni' => $usuario->dni,
                'email' => $usuario->email,
                'telefono' => $usuario->telefono,
                'direccion' => $usuario->direccion,
                'ninos' => $ninos,
                'actividades' => $actividades,
                'pagos' => $pagos,
                'inscripciones' => $inscripciones
            ]
        ]);
    }

    public function misInscripciones(Request $request){
        
        $tutorId = auth()->id();
        $estado = $request->query('estado', 'activas');

        $query = Incripcion::with(['actividad', 'nino', 'precio'])
            ->where('tutor_id', $tutorId);

        $query = Inscripcion::with(['actividad', 'nino'])
            ->where('tutor_id', $tutorId);

        if($estado === 'activas'){
            $query->where('estado', 'activa')
                  ->where(function ($q){
                    $q->whereNull('fecha_fin')
                      ->orWhere('fecha_fin', '>=', now());
                  });
        }

        if($estado === 'caducadas'){
            $query->whereNotNull('fecha_fin')
                  ->where('fecha_fin', '<', now());
        }

        $inscripciones = $query->get();

        return response()->json([
            'tutor_id' => $tutorId,
            'estado_filtrado' => $estado,
            'inscripciones' => $inscripciones->map(function ($i){
                return[
                    'id' => $id->id,
                    'actividad' => $i->actividad->nombre,
                    'nino' => $i->nino->nombre,
                    'fecha_fin' => $i->fecha_fin,
                    'estado' => $i->estado,
                    'esta_caducada' => $id->fecha_fin && $i->fecha_fin < now() ? true : false,
                ];
            })
        ]);
    }


    /**EMPLEADOS */
    public function empleados(){

        $empleados = Usuario::where('rol', 'empleado')->get();

        return response()->json($empleados);
    }

    public function showEmpleado($id){

        $usuario = Usuario::find($id);

        if (!$usuario){
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if ($usuario->rol !== 'empleado'){
            return response()->json(['error' => 'Usuario no es empleado'], 404);
        }
        

        return response()->json([
            'empleado' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'dni' => $usuario->dni,
                'email' => $usuario->email,
                'telefono' => $usuario->telefono,
                'direccion' => $usuario->direccion,
                'rol' => $usuario->rol,
                'contrato_pdf' => $usuario->contrato_pdf,
            ]
        ]);
    }

    public function subirContrato(Request $request, $id){

        $empleado = Usuario::where('rol', 'empleado')->findOrFail($id);

        $request->validate([
            'contrato' => 'required|mimes:pdf|max:2048'
        ]);

        if ($empleado->contrato_pdf){
            Storage::disk('public')->delete('contratos/' . $empleado->contrato_pdf);
        }

        $nombreArchivo = 'empleado_' . $empleado->id . '.pdf';
        $request->file('contrato')->storeAs('contratos', $nombreArchivo, 'public');

        $empleado->contrato_pdf = $nombreArchivo;
        $empleado->save();

        return response()->json([
            'mensaje' => 'Contrato subido correctamente',
            'archivo' => $nombreArchivo
        ]);
    }

    public function perfilTutor($id){
        
        $usuario = Usuario::with([
            'ninosTutor',
            'ninos', 
            'pagos',
            'actividades'
        ])->findOrFail($id);

        $ninos = collect($usuario->ninosTutor)
            ->merge($usuario->ninos)
            ->unique('id')
            ->values()
            ->map(function($n){
                return[
                    'id' => $n->id,
                    'nombre' => $n->nombre,
                    'apellidos' => $n->apellidos,
                    'edad' => $n->fecha_nacimiento
                        ? \Carbon\Carbon::parse($n->fecha_nacimiento)->age
                        : null,
                    'alergias' => $n->alergias,
                    'observaciones' => $n->observaciones,
                ];
            });

        $inscripciones = Inscripcion::with('nino', 'actividad')
            ->where('tutor_id', $usuario->id)
            ->get();

        return response()->json([
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'telefono' => $usuario->telefono,
                'direccion' => $usuario->direccion,
                'ninos' => $ninos,
                'actividades' => $usuario->actividades,
                'pagos' => $usuario->pagos,
                'inscripciones' => $inscripciones
            ]
        ]);
    }
}
