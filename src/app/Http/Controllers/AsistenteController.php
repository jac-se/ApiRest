<?php

namespace App\Http\Controllers;

use App\Models\Asistente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsistenteController extends Controller
{
    /**
     * Recuperar todos los asistentes.
     */
    public function index()
    {
        // Si agregaste la relación evento() en el modelo, puedes usar with('evento')
        $asistentes = Asistente::all();

        $respuesta = [
            'asistentes' => $asistentes,
            'status'     => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Almacenar un asistente nuevo.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'    => 'required',
            'email'     => 'required|email',
            'telefono'  => 'required',
            'evento_id' => 'required|integer|exists:eventos,id',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes o incorrectos',
                'errors'  => $validator->errors(),
                'status'  => 400,
            ];

            return response()->json($respuesta, 400);
        }

        $asistente = Asistente::create([
            'nombre'    => $request->nombre,
            'email'     => $request->email,
            'telefono'  => $request->telefono,
            'evento_id' => $request->evento_id,
        ]);

        $respuesta = [
            'asistente' => $asistente,
            'status'    => 201,
        ];

        return response()->json($respuesta, 201);
    }

    /**
     * Recuperar un asistente específico.
     */
    public function show($id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status'  => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $respuesta = [
            'asistente' => $asistente,
            'status'    => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Actualizar un asistente específico.
     * La ruta usa {asistente}, así que podemos aprovechar el route model binding.
     */
    public function update(Request $request, Asistente $asistente)
    {
        $validator = Validator::make($request->all(), [
            'nombre'    => 'required',
            'email'     => 'required|email',
            'telefono'  => 'required',
            'evento_id' => 'required|integer|exists:eventos,id',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes o incorrectos',
                'errors'  => $validator->errors(),
                'status'  => 400,
            ];

            return response()->json($respuesta, 400);
        }

        $asistente->nombre    = $request->nombre;
        $asistente->email     = $request->email;
        $asistente->telefono  = $request->telefono;
        $asistente->evento_id = $request->evento_id;
        $asistente->save();

        $respuesta = [
            'asistente' => $asistente,
            'status'    => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Eliminar un asistente específico.
     */
    public function destroy($id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status'  => 404,
            ];

            return response()->json($respuesta, 404);
        }

        $asistente->delete();

        $respuesta = [
            'message' => 'Asistente eliminado correctamente',
            'status'  => 200,
        ];

        return response()->json($respuesta, 200);
    }
}
