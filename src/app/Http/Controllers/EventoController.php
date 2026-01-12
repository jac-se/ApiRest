<?php

namespace App\Http\Controllers;

// Importamos el modelo Evento
use App\Models\Evento;

// Importamos Request para manejar datos de la petición HTTP
use Illuminate\Http\Request;

// Importamos Validator para validar los datos recibidos
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    /**
     * Mostrar todos los eventos
     */
    public function index()
    {
        // Obtener todos los registros de la tabla eventos
        $eventos = Evento::all();

        // Respuesta en formato JSON
        $respuesta = [
            'eventos' => $eventos,
            'status' => 200, // OK
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Guardar un nuevo evento
     */
    public function store(Request $request)
    {
        // VALIDACIÓN DE LOS DATOS RECIBIDOS
        $validator = Validator::make($request->all(), [
            'titulo'       => 'required',
            'descripcion'  => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
            'ubicacion'    => 'required',
        ]);

        // ❌ ERROR QUE TENÍAS:
        // Cerrabas la función antes de crear el evento

        // Si falla la validación, regresamos error
        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes o incorrectos',
                'errors'  => $validator->errors(),
                'status'  => 400, // Bad Request
            ];

            return response()->json($respuesta, 400);
        }

        // CREAR EL EVENTO EN LA BASE DE DATOS
        // ❌ ERRORES QUE TENÍAS:
        // - request->descripcion (faltaba $)
        // - $request->$request->fecha_inicio (doble request)

        $evento = Evento::create([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'ubicacion'    => $request->ubicacion,
        ]);

        // Validación extra (opcional)
        // ❌ ERROR QUE TENÍAS:
        // Usabas $Evento con mayúscula, cuando la variable es $evento
        if (!$evento) {
            $respuesta = [
                'message' => 'Error al crear el evento',
                'status'  => 500, // Error del servidor
            ];

            return response()->json($respuesta, 500);
        }

        // Respuesta exitosa
        $respuesta = [
            'evento' => $evento,
            'status' => 201, // Created
        ];

        return response()->json($respuesta, 201);
    }

    /**
     * Mostrar un evento por ID
     */
    public function show($id)
    {
        // Buscar el evento por ID
        $evento = Evento::find($id);

        // Si no existe, regresamos error
        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status'  => 404, // Not Found
            ];

            return response()->json($respuesta, 404);
        }

        // ❌ ERROR QUE TENÍAS:
        // No cerrabas correctamente la función show()

        $respuesta = [
            'evento' => $evento,
            'status' => 200, // OK
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Actualizar un evento existente
     */
    public function update(Request $request, $id)
    {
        // Buscar el evento
        $evento = Evento::find($id);

        // Si no existe, error
        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status'  => 404,
            ];

            return response()->json($respuesta, 404);
        }

        // Validar datos
        $validator = Validator::make($request->all(), [
            'titulo'       => 'required',
            'descripcion'  => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
            'ubicacion'    => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'errors'  => $validator->errors(),
                'status'  => 400,
            ];

            return response()->json($respuesta, 400);
        }

        // ❌ ERROR QUE TENÍAS:
        // fecha_incio estaba mal escrito

        // Actualizar campos
        $evento->titulo       = $request->titulo;
        $evento->descripcion  = $request->descripcion;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_fin    = $request->fecha_fin;
        $evento->ubicacion    = $request->ubicacion;
        $evento->save();

        $respuesta = [
            'evento' => $evento,
            'status' => 200,
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Eliminar un evento
     */
    public function destroy($id)
    {
        // Buscar el evento
        $evento = Evento::find($id);

        // Si no existe, error
        if (!$evento) {
            $respuesta = [
                'message' => 'Evento no encontrado',
                'status'  => 404,
            ];

            return response()->json($respuesta, 404);
        }

        // Eliminar el evento
        $evento->delete();

        // ❌ ERROR QUE TENÍAS:
        // $resouesta mal escrita y luego retornabas $respuesta

        $respuesta = [
            'message' => 'Evento eliminado correctamente',
            'status'  => 200,
        ];

        return response()->json($respuesta, 200);
    }
}
