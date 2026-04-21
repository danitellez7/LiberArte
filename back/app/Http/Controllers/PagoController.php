<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Usuario;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    //------------------------------------------------
    //CREAR UN PAGO
    //------------------------------------------------
    public function store(Request $request){
        //Validación
            $validated = $request->validate([
            'tutor_id' => 'required|exists:usuarios,id',
            'mes' => 'required|string',
            'total_sin_descuento' => 'required|numeric',
            'descuento_aplicado' => 'required|numeric',
            'total_final' => 'required|numeric',
            'estado' => 'required|string',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
            'notas' => 'nullable|string',


            'inscripciones' => 'required|array',
            'inscripciones.*.id' => 'required|exists:inscripciones,id',
            'inscripciones.*.importe' => 'required|numeric',
        ]);

        //Crear el pago
        $pago = Pago::create([
            'tutor_id' => $validated['tutor_id'],
            'mes' => $validated['mes'],
            'total_sin_descuento' => $validated['total_sin_descuento'],
            'descuento_aplicado' => $validated['descuento_aplicado'],
            'total_final' => $validated['total_final'],
            'estado' => $validated['estado'],
            'metodo_pago' => $validated['metodo_pago'],
            'fecha_pago' => $validated['fecha_pago'],
            'notas' => $validated['notas'] ?? null,
        ]);

        //Asignar inscripciones con importe
        $syncData = [];

        foreach($validated['inscripciones'] as $item){
            $syncData[$item['id']] = ['importe' => $item['importe']];
        }   

        //Guardamos inscripciones en la tabla pivote
        $pago->inscripcionesCobradas()->sync($syncData);

        //Devolver respuesta con relaciones cargadas
        return response()->json([
            'message' => 'Pago creado correctamente',
            'pago' => $pago->load('inscripcionesCobradas')
        ]);
    }

    //------------------------------------------------
    //LISTAR UN PAGO
    //------------------------------------------------
    public function index(){
        $pagos = Pago::with([
            'tutor',
            'inscripcionesCobradas.actividad',
            'inscripcionesCobradas.nino'
        ])->get();

        $respuesta = $pagos->map(function ($pago){
            return [
                'id' => $pago->id,
                'mes' => $pago->mes,
                'total_final' => $pago->total_final,
                'estado' => $pago->estado,
                'fecha_pago' => $pago->fecha_pago,
                'tutor' => $pago->tutor->nombre ?? null,

                'inscripciones' =>$pago->inscripcionesCobradas->map(function ($inscripcion){
                    return [
                        'actividad' => $inscripcion->actividad->nombre ?? null,
                        'nino' => $inscripcion->nino->nombre ?? null,
                        'importe' => $inscripcion->pivot->importe
                    ];
                })
            ];
        });
    
        return response()->json($respuesta);
    }

    //------------------------------------------------
    //ACTUALIZAR UN PAGO
    //------------------------------------------------
    public function update(Request $request, $id){
        //Buscamos el pago
        $pago = Pago::findOrFail($id);

        //Validamos
        $validated = $request->validate([
            'tutor_id' => 'required|exists:usuarios,id',
            'mes' => 'required|string',
            'total_sin_descuento' => 'required|numeric',
            'descuento_aplicado' => 'required|numeric',
            'total_final' => 'required|numeric',
            'estado' => 'required|string',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
            'notas' => 'nullable|string',

            'inscripciones' => 'required|array',
            'inscripciones.*.id' => 'required|exists:inscripciones,id',
            'inscripciones.*.importe' => 'required|numeric',
        ]);

        //Actualizamos datos de pago 
        $pago->update([
            'tutor_id' => $validated['tutor_id'],
            'mes' => $validated['mes'],
            'total_sin_descuento' => $validated['total_sin_descuento'],
            'descuento_aplicado' => $validated['descuento_aplicado'],
            'total_final' => $validated['total_final'],
            'estado' => $validated['estado'],
            'metodo_pago' => $validated['metodo_pago'],
            'fecha_pago' => $validated['fecha_pago'],
            'notas' => $validated['notas'] ?? null,
        ]);

        //Preparamos datos para sync
        $syncData = [];

        foreach($validated['inscripciones'] as $item){
            $syncData[$item['id']] = ['importe' => $item['importe']];
        }   

        //Actualizamos datos de la tabla
        $pago->inscripcionesCobradas()->sync($syncData);

        //Respuesta
        return response()->json([
            'message' => 'Pago actualizado correctamente',
            'pago' => $pago->load('inscripcionesCobradas')
        ]);
    }

    //------------------------------------------------
    //VER UN PAGO CONCRETO
    //------------------------------------------------
    public function show($id){

        $pago = Pago::with([
            'tutor',
            'inscripcionesCobradas.actividad',
            'inscripcionesCobradas.nino'
        ])->findOrFail($id);

            $respuesta =  [
                'id' => $pago->id,  
                'mes' => $pago->mes,
                'total_final' => $pago->total_final,
                'estado' => $pago->estado,
                'fecha_pago' => $pago->fecha_pago,
                'tutor' => $pago->tutor->nombre ?? null,

                'inscripciones' => $pago->inscripcionesCobradas->map(function($inscripcion){
                    return[
                        'actividad' =>$inscripcion->actividad->nombre ?? null,
                        'nino' =>$inscripcion->nino->nombre ?? null,
                        'importe' =>$inscripcion->pivot->importe
                    ];
                })
            ];

        return response()->json($respuesta);
    } 

    //------------------------------------------------
    //ELIMINAR UN PAGO
    //------------------------------------------------
    public function destroy($id){

        //Buscamos el pago
        $pago = Pago::findOrFail($id);

        //Eliminar relaciones de la tabla pivote 
        $pago->inscripcionesCobradas()->detach();

        //Eliminar el pago
        $pago->delete();

        //Respuesta
        return response()->json([
            'message' => 'Pago eliminado correctamente.'
        ]);
    }

    //------------------------------------------------
    //PAGOS POR TUTOR
    //------------------------------------------------
    public function pagoPorTutor($tutor){
        
        $pagos = Pago::with('inscripcionesCobradas')
                     ->where('tutor_id', $tutor)
                     ->get();
        
        return response()->json([
            'pagos' => $pagos
        ]);
    }

    //------------------------------------------------
    //PAGOS POR TUTOR Y MES
    //------------------------------------------------
    public function pagoPorTutorYMes($tutor, $mes){
        
        $pago = Pago::with('inscripcionesCobradas')
                     ->where('tutor_id', $tutor)
                     ->where('mes', $mes)
                     ->first();
        
        return response()->json([
            'pago' => $pago
        ]);
    }

    //------------------------------------------------
    //DEUDAS TOTALES DEL TUTOR
    //------------------------------------------------
    public function deudaTutor($tutor){
        
        $deuda = Pago::where('tutor_id', $tutor)
                     ->where('estado', 'pendiente')
                     ->sum('total_final');
        
        return response()->json([
            'tutor_id' => $tutor,
            'deuda_total' => $deuda
        ]);
    }

    //------------------------------------------------
    //MIS PAGOS
    //------------------------------------------------
    public function misPagos(){

        $tutorId = auth()->id();

        $pagos = Pago::with([
            'tutor',
            'inscripcionesCobradas.actividad',
            'inscripcionesCobradas.nino'
        ])
        ->where('tutor_id', $tutorId)
        ->get();

        $respuesta = $pagos->map(function ($pago){
            return[
                'id' => $pago->id,
                'mes' => $pago->mes,
                'total_final' => $pago->total_final,
                'estado' => $pago->estado,
                'fecha_pago' => $pago->fecha_pago,
                'tutor' => $pago->tutor->nombre ?? null,

                'inscripciones' => $pago->inscripcionesCobradas->map(function($inscripcion){
                    return[
                        'actividad' =>$inscripcion->actividad->nombre ?? null,
                        'nino' =>$inscripcion->nino->nombre ?? null,
                        'importe' =>$inscripcion->pivot->importe
                    ];
                })
            ];
        });

        return response()->json($respuesta);
    }

    //------------------------------------------------
    //MARCAR UN PAGO COMO PAGADO
    //------------------------------------------------
    public function pagar($id){
        $pago = Pago::findOrFail($id);

        $pago->estado = 'pagado';
        $pago->fecha_pago = now();

        $pago->save();

        return response()->json([
            'message' => 'Pago marcado como pagado correctamente.',
            'pago' => $pago
        ]);
    }

    //------------------------------------------------
    //CREAR UN NUEVO PAGO
    //------------------------------------------------
    public function crearPago(Request $request){

        //Validación inicial
        $validated = $request->validate([
            'tutor_id' => 'required|exists:usuarios,id',
            'mes' => 'required|date',
            'total_sin_descuento' => 'required|numeric|min:0',
            'descuento_aplicado' => 'required|numeric|min:0',
            'total_final' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,pagado',
            'fecha_pago' => 'nullable|date',
        ]);

        //Validación según el cálculo con tolerancia 
        $esperado = $validated['total_sin_descuento'] - $validated['descuento_aplicado'];
        $diferencia = abs($esperado - $validated['total_final']);

        if($diferencia > 0.01){
            return response()->json([
                'error' => 'El total_final no coincide con el total_sin_descuento - descuento_aplicado.'
            ], 422);
        }

        //Validación según el estado 
        if($validated['estado'] === 'pendiente'){

            if(!empty($validated['fecha_pago'])){
                return response()->json([
                    'error' => 'Un pago pendiente no puede tener fecha de pago.'
                ], 422);
            }

            $validated['fecha_pago'] = null;
        }

        if($validated['estado'] === 'pagado'){

            if(empty($validated['fecha_pago'])){
                $validated['fecha_pago'] = now();
            }
        }

        //Creamos el pago
        $pago = Pago::create($validated);

        return response()->json([
            'message' => 'Pago creado corretamente.',
            'pago' => $pago
        ], 201);
    }

    //------------------------------------------------
    //OBTENER PAGOS POR DNI DEL TUTOR
    //------------------------------------------------
    public function obtenerPagosPorDni($dni){

        //Buscamos al usuario por dni
        $tutor = Usuario::where('dni', $dni)->first();

        //Si no existe mandamos un mensaje genérico
        if(!$tutor || $tutor->rol !== 'tutor'){
            return response()->json([
                'message' => 'No se encontraron pagos para este DNI.'
            ], 404);
        }

        //Buscar pagos del tutor
        $pagos = Pago::where('tutor_id', $tutor->id)->get();

        //Si no tiene pagos, mismo mensaje
        if($pagos->isEmpty()){
            return response()->json([
                'message' => 'No se encontraron pagos para este DNI.'
            ], 404);
        }

        //Devolver pagos
        return response()->json([
            'tutor' => [
                'id' => $tutor->id,
                'nombre' => $tutor->nombre,
                'dni' => $tutor->dni
            ],
            'pagos' => $pagos
        ], 200);
    }
}
