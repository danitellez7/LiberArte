<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

    class PerfilController extends Controller{

        public function actualizar(Request $request){

            //--------------------------------------------------------
            //OBTENEMOS AL USUARIO AUTENTICADO
            //--------------------------------------------------------
            $user = $request->user();

            //--------------------------------------------------------
            //VALIDACIÓN DE DATOS
            //--------------------------------------------------------
            $request->validate([
                'nombre' => 'nullable|string|max:255',
                'apellidos' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:255',
                'dni' => 'nullable|string|max:20',
                'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            ]);


            //--------------------------------------------------------
            //ACTUALIZAR FOTO
            //--------------------------------------------------------
            $user->update([
                'nombre' =>$request->nombre,
                'apellidos' =>$request->apellidos,
                'telefono' =>$request->telefono,
                'direccion' =>$request->direccion,
                'dni' =>$request->dni,
            ]);

            //--------------------------------------------------------
            //SI SUBE UNA FOTO NUEVA
            //--------------------------------------------------------
            if($request->hasFile('foto_perfil')){

                //Borrar la foto antigua
                if($user->foto_perfil){
                    Storage::disk('public')->delete($user->foto_perfil);
                }

                //Obtenemos la extension original
                $extension= $request->file('foto_perfil')->getClientOriginalExtension();

                //Creamos nombre del archivo
                if($user->nombre && $user->apellidos){
                    $nombreArchivo = strtolower(str_replace(' ', '_', $user->nombre . '_'. $user->apellidos ));
                }else{
                    $nombreArchivo = 'usuario_' . $user->id;
                }

                $nombreFinal = $nombreArchivo . '.' . $extension;

                //Redimensionamos la imagen
                $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
                
                //Creamos instancia
                $imagen = $manager->read($request->file('foto_perfil'));

                //Redimensionamos la imagen 
                $imagen = $imagen->cover(400,400);

                //Codificamos segun la extensión
                switch($extension){
                    case 'jpg':
                    case 'jpeg':
                        $imagen = $imagen->toJpeg(80);
                        break;
                    case 'png':
                        $imagen = $imagen->toPng;
                        break;
                    case 'webp':
                        $imagen = $imagen->toWebp(80);
                        break;
                    default:
                        $imagen = $imagen->toJpeg(80);
                        break;
                }

                //Guardamos la imagen
                $ruta = 'fotos_perfil/' . $nombreFinal;
                Storage::disk('public')->put($ruta, $imagen);

                //Guardamos la ruta en la base de datos
                $user->foto_perfil = $ruta;
                $user->save();

            }

            //--------------------------------------------------------
            //RESPUESTA
            //--------------------------------------------------------

            return response()->json([
                'message' => 'Perfilactualizado correctamente',
                'user' => $user
            ]);
        }
    }

