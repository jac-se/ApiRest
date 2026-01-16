<?php

namespace App\Http\Controllers;

use App\Models\Ponente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PonenteController extends Controller
{
    /**
     * Recuperar todos los ponentes.
     */
    public function index()
    {
        $ponentes = Ponente::all();

        $respuesta = [
            'ponentes' => $ponentes,
            'status'   => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Almacenar un ponente nuevo.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'       => 'required',
            'email'        => 'required|email|unique:ponentes,email',
            'especialidad' => 'nullable',
            'biografia'    => 'nullable',
            'telefono'     => 'nullable',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes o incorrectos',
                'errors'  => $validator->errors(),
                'status'  => 400,
            ];

            return response()->json($respuesta, 400);
        }

        $ponente = Ponente::create([
            'nombre'       => $request->nombre,
            'email'        => $request->email,
            'especialidad' => $request->especialidad,
            'biografia'    => $request->biografia,
            'telefono'     => $request->telefono,
        ]);

        $respuesta = [
            'ponente' => $ponente,
            'status'  => 201,
        ];

        return response()->json($respuesta, 201);
    }

    /**
     * Recuperar un ponente específico.
     */
    public function show($id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            $respuesta = [
                'message' => 'Ponente no encontrado',
                'status'  => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $respuesta = [
            'ponente' => $ponente,
            'status'  => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Actualizar un ponente específico.
     * Usamos route model binding con {ponente} en la ruta.
     */
    public function update(Request $request, Ponente $ponente)
    {
        $validator = Validator::make($request->all(), [
            'nombre'       => 'required',
            'email'        => 'required|email|unique:ponentes,email,' . $ponente->id,
            'especialidad' => 'nullable',
            'biografia'    => 'nullable',
            'telefono'     => 'nullable',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes o incorrectos',
                'errors'  => $validator->errors(),
                'status'  => 400,
            ];

            return response()->json($respuesta, 400);
        }

        $ponente->nombre       = $request->nombre;
        $ponente->email        = $request->email;
        $ponente->especialidad = $request->especialidad;
        $ponente->biografia    = $request->biografia;
        $ponente->telefono     = $request->telefono;
        $ponente->save();

        $respuesta = [
            'ponente' => $ponente,
            'status'  => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Eliminar un ponente específico.
     */
    public function destroy($id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            $respuesta = [
                'message' => 'Ponente no encontrado',
                'status'  => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $ponente->delete();

        $respuesta = [
            'message' => 'Ponente eliminado correctamente',
            'status'  => 200,
        ];

        return response()->json($respuesta, 200);
    }
}
